<?php namespace Vankosoft\CatalogBundle\EventSubscriber\Event;

/**
 * MANUAL: https://q.agency/blog/custom-events-with-symfony5/
 */
final class CreateSubscriptionEvent
{
    public const NAME   = 'vs_payment.create_subscription';
    
    /** @var object */
    private $pricingPlan;
    
    /** @var bool */
    private $setRecurringPayments;
    
    public function __construct( $pricingPlan, $setRecurringPayments )
    {
        $this->pricingPlan          = $pricingPlan;
        $this->setRecurringPayments = $setRecurringPayments;
    }
    
    public function getPricingPlan()
    {
        return $this->pricingPlan;
    }
    
    public function getSetRecurringPayments()
    {
        return $this->setRecurringPayments;
    }
}