from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import SubscriptionViewSet
from subscriptions.views import initiate_payment, payment_callback
from rest_framework.authtoken.views import obtain_auth_token
from . import views

router = DefaultRouter()
router.register(r'subscriptions', SubscriptionViewSet, basename='subscription')

urlpatterns = [
     path('', include(router.urls)),
     path('initiate-payment/', initiate_payment, name='initiate_payment'),
     path('payment-callback/', payment_callback, name='payment_callback'),
     path('subscribe/', views.subscribe_view, name='subscribe'),
]
