import json
import base64
import requests
from django.views.decorators.csrf import csrf_exempt
from django.http import JsonResponse, HttpResponseNotAllowed
from django.utils import timezone
from rest_framework import viewsets
from .models import Subscription
from .serializers import SubscriptionSerializer
from rest_framework.permissions import IsAuthenticated
from django.conf import settings
from django.core.mail import send_mail
from django.shortcuts import render
from rest_framework.decorators import api_view, permission_classes
from rest_framework.permissions import AllowAny

def subscribe_view(request):
     return render(request, 'subscribe.html') 

class SubscriptionViewSet(viewsets.ModelViewSet):
    queryset = Subscription.objects.all()
    serializer_class = SubscriptionSerializer
    permission_classes = [IsAuthenticated]

    def get_queryset(self):
        return self.queryset.filter(user=self.request.user)

    def perform_create(self, serializer):
        serializer.save(user=self.request.user)




@api_view(['POST'])
@permission_classes([AllowAny])
def initiate_payment(request):
    user = request.user if request.user.is_authenticated else None

    if request.method == 'POST':
        try:
            data = json.loads(request.body)
            print("📥 Incoming data:", data)
            phone_number = data.get('phone_number')
            plan = data.get('plan')

            if not phone_number or not plan:
                raise Exception("Missing phone number or plan")

            # Set amounts based on plan
            plan_amounts = {
                'basic': 1000,
                'premium': 2500,
                'pro': 5000
            }
            amount = plan_amounts.get(plan)
            if not amount:
                raise Exception("Invalid subscription plan selected.")

            # Safaricom credentials from settings.py
            consumer_key = settings.DARAJA_CONSUMER_KEY
            consumer_secret = settings.DARAJA_CONSUMER_SECRET
            passkey = settings.DARAJA_PASSKEY
            business_short_code = settings.DARAJA_SHORTCODE
            callback_url = settings.DARAJA_CALLBACK_URL
            base_url = 'https://sandbox.safaricom.co.ke'

            # Get access token
            auth_url = f'{base_url}/oauth/v1/generate?grant_type=client_credentials'
            auth = (consumer_key, consumer_secret)
            res = requests.get(auth_url, auth=auth)
            access_token = res.json().get('access_token')

            if not access_token:
                raise Exception("Failed to retrieve M-Pesa access token.")

            # Generate timestamp and password
            timestamp = timezone.now().strftime('%Y%m%d%H%M%S')
            password = base64.b64encode(
                f'{business_short_code}{passkey}{timestamp}'.encode()).decode()

            # Prepare STK Push payload
            payload = {
                "BusinessShortCode": business_short_code,
                "Password": password,
                "Timestamp": timestamp,
                "TransactionType": "CustomerPayBillOnline",
                "Amount": amount,
                "PartyA": phone_number,
                "PartyB": business_short_code,
                "PhoneNumber": phone_number,
                "CallBackURL": callback_url,
                "AccountReference": "Wellness Subscription",
                "TransactionDesc": f"{plan.capitalize()} Plan Subscription"
            }

            headers = {
                "Authorization": f"Bearer {access_token}",
                "Content-Type": "application/json"
            }

            stk_url = f"{base_url}/mpesa/stkpush/v1/processrequest"
            response = requests.post(stk_url, json=payload, headers=headers)
            response_data = response.json()

            print("📩 STK Push Response:")
            print(json.dumps(response_data, indent=4))

            # Save subscription with Pending status
            Subscription.objects.create(
                user=request.user if request.user.is_authenticated else None,
                phone_number=phone_number,
                amount=amount,
                plan=plan,
                payment_status='Pending',
                checkout_request_id=response_data.get('CheckoutRequestID'),
                merchant_request_id=response_data.get('MerchantRequestID'),
                transaction_date=timezone.now(),
                mpesa_receipt_number=""
            )

            return JsonResponse(response_data)

        except Exception as e:
            import traceback
            traceback.print_exc()
            return JsonResponse({"error": str(e)}, status=400)

    return HttpResponseNotAllowed(['POST'])


   # Handles payment confirmation sent by Safaricom after STK push is completed
@csrf_exempt 
def payment_callback(request):
    if request.method == 'POST':
        try:
            # Parse the incoming JSON request from Safaricom
            data = json.loads(request.body)

            # Extract the core callback data
            callback_data = data.get('Body', {}).get('stkCallback', {})

            # Check the result of the transaction (0 means success)
            result_code = callback_data.get('ResultCode')

            if result_code == 0:
                # If transaction was successful, extract metadata
                metadata = callback_data.get('CallbackMetadata', {}).get('Item', [])

                # Convert metadata into a flat dictionary for easy access
                transaction_data = {item['Name']: item.get('Value') for item in metadata}

                # Retrieve transaction details
                receipt = transaction_data.get('MpesaReceiptNumber')
                amount = transaction_data.get('Amount')
                phone = transaction_data.get('PhoneNumber')
                transaction_date = transaction_data.get('TransactionDate')
                checkout_request_id = callback_data.get('CheckoutRequestID')
                merchant_request_id = callback_data.get('MerchantRequestID')

                # Update the existing Subscription record
                subscription = Subscription.objects.filter(checkout_request_id=checkout_request_id).first()
                if subscription:
                    subscription.mpesa_receipt_number = receipt
                    subscription.amount = amount
                    subscription.transaction_date = timezone.now()
                    subscription.merchant_request_id = merchant_request_id
                    subscription.payment_status = 'Paid'
                    subscription.save()

            # Always respond with ResultCode 0 to acknowledge Safaricom callback
            return JsonResponse({"ResultCode": 0, "ResultDesc": "Accepted"})

        except Exception as e:
            # If anything goes wrong, return an error response
            return JsonResponse({'error': str(e)}, status=400)

    # Reject non-POST requests (callback should only use POST)
    return HttpResponseNotAllowed(['POST'])
