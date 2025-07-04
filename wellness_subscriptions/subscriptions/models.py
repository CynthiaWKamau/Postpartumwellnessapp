from django.db import models
from django.contrib.auth.models import User

# Create your models here.
class Subscription(models.Model):
    PLAN_CHOICES=[
        ('basic', 'Basic'),
        ('premium', 'Premium'),
        ('pro', 'Pro'),
    ]

    user = models.ForeignKey(User, on_delete=models.CASCADE)
    phone_number = models.CharField(max_length=20)
    amount = models.DecimalField(max_digits=10, decimal_places=2)
    mpesa_receipt_number = models.CharField(max_length=100)
    checkout_request_id = models.CharField(max_length=100)
    merchant_request_id = models.CharField(max_length=100)
    transaction_date = models.DateTimeField()
    payment_status = models.CharField(max_length=20)
    created_at = models.DateTimeField(auto_now_add=True)

    def __str__(self):
        return f"{self.user.username} - {self.amount} - {self.payment_status}"