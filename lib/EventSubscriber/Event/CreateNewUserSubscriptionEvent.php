<?php namespace Vankosoft\CatalogBundle\EventSubscriber\Event;

use Vankosoft\CatalogBundle\Model\Interfaces\UserSubscriptionAwareInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanInterface;

/**
 * MANUAL: https://q.agency/blog/custom-events-with-symfony5/
 */
final class CreateNewUserSubscriptionEvent
{
    public const NAME   = 'vs_payment.create_new_user_subscription';
    
    /** @var UserSubscriptionAwareInterface */
    private $user;
    
    /** @var PricingPlanInterface */
    private $pricingPlan;
    
    public function __construct(
        UserSubscriptionAwareInterface $user,
        PricingPlanInterface $pricingPlan
    ) {
        $this->user         = $user;
        $this->pricingPlan  = $pricingPlan;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function getPricingPlan()
    {
        return $this->pricingPlan;
    }
}