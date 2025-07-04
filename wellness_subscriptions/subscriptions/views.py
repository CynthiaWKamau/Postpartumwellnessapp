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

class SubscriptionViewSet(viewsets.ModelViewSet):
    queryset = Subscription.objects.all()
    serializer_class = SubscriptionSerializer
    permission_classes = [IsAuthenticated]

    def get_queryset(self):
        return self.queryset.filter(user=self.request.user)

    def perform_create(self, serializer):
        serializer.save(user=self.request.user)


@csrf_exempt
def initiate_payment(request):
    if request.method == 'POST':
        try:
            data = json.loads(request.body)

            phone_number = data.get('phone_number')
            plan = data.get('plan')

            # Set amounts based on plan
            plan_amounts = {
                'basic': 200,
                'premium': 500,
                'pro': 1000
            }
            amount = plan_amounts.get(plan, 0)

            # Safaricom credentials
            consumer_key = '15sTBlHmq8RR5Tgb47YXHc4CaJ9NsMKiCKBMkNgc4OiyOR1G'
            consumer_secret = 'p0B6ahZVgwVpizREZU5F4ayo8jx5Y4BkLcCG1ZQuIyyyAsmgqGdImj1UJl1v2l8I'
            business_short_code = '174379'
            passkey = 'YOUR_PASSKEY'
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
                "CallBackURL": "https://yourdomain.com/api/payment/callback/",
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