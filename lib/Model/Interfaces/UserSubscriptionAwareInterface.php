<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;

interface UserSubscriptionAwareInterface
{
    public function getPricingPlanSubscriptions(): Collection;
}