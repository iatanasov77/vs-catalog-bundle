<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

interface PricingPlanAwareInterface
{
    public function getPricingPlan(): ?PricingPlanInterface;
    public function setPricingPlan( ?PricingPlanInterface $pricingPlan ): self;
}