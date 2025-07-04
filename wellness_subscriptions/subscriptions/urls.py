from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import SubscriptionViewSet
from django.urls import path
from .views import initiate_payment

router = DefaultRouter()
router.register(r'subscriptions', SubscriptionViewSet, basename='subscription')

urlpatterns = [
    path('', include(router.urls)),
     path('initiate-payment/', initiate_payment, name='initiate_payment'),
]
