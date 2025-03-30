<?php namespace Vankosoft\CatalogBundle\Model\Traits;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

use Vankosoft\UsersSubscriptionsBundle\Model\Interfaces\SubscriptionInterface;
use Vankosoft\UsersSubscriptionsBundle\Model\Interfaces\PayedServiceInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanSubscriptionInterface;

trait UserSubscriptionAwareEntity
{
    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanSubscriptionInterface", mappedBy="user", cascade={"persist", "remove"})
     */
    #[ORM\OneToMany(targetEntity: PricingPlanSubscriptionInterface::class, mappedBy: "user", indexBy: "pricing_plan_id", cascade: ["persist", "remove"], orphanRemoval: true)]
    protected $pricingPlanSubscriptions;
    
    /**
     * @return Collection|SubscriptionInterface[]
     */
    public function getPricingPlanSubscriptions(): Collection
    {
        return $this->pricingPlanSubscriptions;
    }
    
    public function setPricingPlanSubscriptions( Collection $pricingPlanSubscriptions ): self
    {
        $this->pricingPlanSubscriptions  = $pricingPlanSubscriptions;
        
        return $this;
    }
    
    public function addPricingPlanSubscription( SubscriptionInterface $pricingPlanSubscription ): self
    {
        if ( ! $this->pricingPlanSubscriptions->contains( $pricingPlanSubscription ) ) {
            $this->pricingPlanSubscriptions[]    = $pricingPlanSubscription;
            $pricingPlanSubscription->setUser( $this );
        }
        
        return $this;
    }
    
    public function removePricingPlanSubscription( SubscriptionInterface $pricingPlanSubscription ): self
    {
        if ( $this->pricingPlanSubscriptions->contains( $pricingPlanSubscription ) ) {
            $this->pricingPlanSubscriptions->removeElement( $pricingPlanSubscription );
            $pricingPlanSubscription->setUser( null );
        }
        
        return $this;
    }
}