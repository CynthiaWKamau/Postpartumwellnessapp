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

class SubscriptionViewSet(viewsets.ModelViewSet):
    queryset = Subscription.objects.all()
    serializer_class = SubscriptionSerializer
    permission_classes = [IsAuthenticated]

    def get_queryset(self):
        return self.queryset.filter(user=self.request.user)

    def perform_create(self, serializer):
        serializer.save(user=self.request.user)
    def subscribe_view(request):
     return render(request, 'subscribe.php') 


@csrf_exempt

def initiate_payment(request):
    if request.method == 'POST':
        try:
            data = json.loads(request.body)

            phone_number = data.get('phone_number')
            plan = data.get('plan')

            # Set amounts based on plan
            plan_amounts = {
                'basic': 2000,
                'premium': 5000,
                'pro': 1000
            }
            amount = plan_amounts.get(plan, 0)

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

            # Timestamp and password
            timestamp = timezone.now().strftime('%Y%m%d%H%M%S')
            password = base64.b64encode(
                f'{business_short_code}{passkey}{timestamp}'.encode()).decode()

            # STK push payload
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

            return JsonResponse(response.json())

        except Exception as e:
            return JsonResponse({'error': str(e)}, status=400)

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

                # Save the successful transaction to the database
                Subscription.objects.create(
                    phone_number=phone,
                    amount=amount,
                    mpesa_receipt_number=receipt,
                    checkout_request_id=checkout_request_id,
                    merchant_request_id=merchant_request_id,
                    transaction_date=transaction_date,
                    payment_status='Paid'
                )

            # Always respond with ResultCode 0 to acknowledge Safaricom callback
            return JsonResponse({"ResultCode": 0, "ResultDesc": "Accepted"})

        except Exception as e:
            # If anything goes wrong, return an error response
            return JsonResponse({'error': str(e)}, status=400)

    # Reject non-POST requests (callback should only use POST)
    return HttpResponseNotAllowed(['POST'])
