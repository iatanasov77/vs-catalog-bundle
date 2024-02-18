<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Vankosoft\PaymentBundle\Model\Interfaces\PayableObjectInterface;

interface PayableObjectAwareInterface
{
    public function getSubscription(): ?PricingPlanSubscriptionInterface;
    public function setSubscription( PricingPlanSubscriptionInterface $subscription ): self;
    public function getProduct(): ?ProductInterface;
    public function setProduct( ProductInterface $product ): self;
    public function getProductName(): ?string;
    public function setProductName(?string $productName): void;
    public function getObject(): PayableObjectInterface;
}