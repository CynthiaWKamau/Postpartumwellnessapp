from django.db import models
from django.contrib.auth.models import User

# Create your models here.
class Subscription(models.Model):
    PLAN_CHOICES=[
        ('basic', 'Basic'),
        ('premium', 'Premium'),
        ('pro', 'Pro'),
    ]

    user = models.ForeignKey(User, on_delete=models.SET_NULL, null=True, blank=True)  # <-- important
    phone_number = models.CharField(max_length=15)
    amount = models.DecimalField(max_digits=10, decimal_places=2)
    plan = models.CharField(max_length=50)

   # STK Push data
    payment_status = models.CharField(max_length=20, default='Pending')
    checkout_request_id = models.CharField(max_length=100, blank=True, null=True)
    merchant_request_id = models.CharField(max_length=100, blank=True, null=True)
    mpesa_receipt_number = models.CharField(max_length=100, blank=True, null=True)
    transaction_date = models.DateTimeField(blank=True, null=True)

    created_at = models.DateTimeField(auto_now_add=True)

    def __str__(self):
          return f"{self.user.username} - {self.plan} - {self.amount} - {self.payment_status}"