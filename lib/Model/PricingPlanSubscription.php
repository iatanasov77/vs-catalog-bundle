<?php namespace Vankosoft\CatalogBundle\Model;

use Sylius\Component\Resource\Model\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanSubscriptionInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanInterface;
use Vankosoft\PaymentBundle\Model\Interfaces\GatewayConfigInterface;
use Vankosoft\UsersSubscriptionsBundle\Model\Interfaces\SubscribedUserInterface;
use Vankosoft\PaymentBundle\Model\Traits\PayableObjectTrait;

class PricingPlanSubscription implements PricingPlanSubscriptionInterface
{
    use TimestampableTrait;
    use PayableObjectTrait;
    
    /** @var integer */
    protected $id;
    
    /**
     * Relation to the PricingPlan entity
     *
     * @var PricingPlanInterface
     */
    protected $pricingPlan;
    
    /**
     * Relation to the User entity
     *
     * @var SubscribedUserInterface
     */
    protected $user;
    
    /** @var bool */
    protected $recurringPayment = false;
    
    /** @var \DateTimeInterface */
    protected $expiresAt;
    
    /**
     * This field will store: Subscription Customer and Price Ids
     * to Can Find Subscription Id for Canceling and etc.
     *
     * @var array
     */
    protected $gatewayAttributes;
    
    public function __construct()
    {
        $this->orderItems           = new ArrayCollection();
        $this->gatewayAttributes    = [];
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getPricingPlan(): PricingPlanInterface
    {
        return $this->pricingPlan;
    }
    
    public function setPricingPlan( PricingPlanInterface $pricingPlan )
    {
        $this->pricingPlan = $pricingPlan;
        
        return $this;
    }
    
    public function isForPricingPlan( PricingPlanInterface $pricingPlan ): bool
    {
        return $this->pricingPlan == $pricingPlan;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function setUser($user)
    {
        $this->user = $user;
        
        return $this;
    }
    
    public function isRecurringPayment(): bool
    {
        return $this->recurringPayment;
    }
    
    public function getRecurringPayment(): bool
    {
        return $this->recurringPayment;
    }
    
    /**
     * @param bool
     */
    public function setRecurringPayment( ?bool $recurringPayment )
    {
        $this->recurringPayment = (bool) $recurringPayment;
        
        return $this;
    }
    
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }
    
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
        
        return $this;
    }
    
    public function getGatewayAttributes(): array
    {
        return $this->gatewayAttributes ?: [];
    }
    
    public function setGatewayAttributes( array $gatewayAttributes ): self
    {
        $this->gatewayAttributes    = $gatewayAttributes;
        
        return $this;
    }
    
    public function isPaid(): bool
    {
        return $this->expiresAt && ( $this->expiresAt > ( new \DateTime() ) );
    }
    
    public function getCode(): ?string
    {
        return $this->pricingPlan ? $this->pricingPlan->getSubscriptionCode() : null;
    }
    
    public function getSubscriptionCode(): ?string
    {
        return $this->pricingPlan ? $this->pricingPlan->getSubscriptionCode() : null;
    }
    
    public function getServiceCode(): ?string
    {
        return $this->pricingPlan ? $this->pricingPlan->getServiceCode() : null;
    }
    
    public function getPeriodCode(): ?string
    {
        return $this->pricingPlan ? $this->pricingPlan->getPeriodCode() : null;
    }
    
    public function getSubscriptionPriority(): ?int
    {
        return $this->pricingPlan ? $this->pricingPlan->getSubscriptionPriority() : null;
    }
    
    public function getTotalAmount()
    {
        return $this->getPrice();
    }
    
    public function getGateway(): ?GatewayConfigInterface
    {
        $gatewayConfig  = null;
        if ( $this->orderItems->count() ) {
            $gatewayConfig  = $this->orderItems->last()->getOrder()->getPaymentMethod()->getGateway();
        }
        
        return $gatewayConfig;
    }
    
    public function getGatewayFactory(): ?string
    {
        $gatewayFactory = null;
        if ( $this->orderItems->count() ) {
            $gatewayFactory = $this->orderItems->last()->getOrder()->getPaymentMethod()->getGateway()->getFactoryName();
        }
        
        return $gatewayFactory;
    }
}