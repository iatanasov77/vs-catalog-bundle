<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;
use Vankosoft\UsersSubscriptionsBundle\Model\Interfaces\SubscriptionInterface;

interface PricingPlanSubscriptionInterface extends ResourceInterface, SubscriptionInterface, PayableObjectInterface
{
    public function getPricingPlan(): PricingPlanInterface;
    public function getOrderItem(): OrderItemInterface;
    public function isPaid(): bool;
    public function isActive(): bool;
    public function getGatewayAttributes(): array;
    public function isRecurringPayment(): bool;
    public function getRecurringPayment(): bool;
}