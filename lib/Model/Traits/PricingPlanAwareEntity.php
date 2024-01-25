<?php namespace Vankosoft\CatalogBundle\Model\Traits;

use Doctrine\ORM\Mapping as ORM;
use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanInterface;

trait PricingPlanAwareEntity
{
    /**
     * @var PricingPlanInterface | null
     * 
     * @ORM\ManyToOne(targetEntity="Vankosoft\PaymentBundle\Model\Interfaces\PricingPlanInterface")
     * @ORM\JoinColumn(name="pricing_plan_id", referencedColumnName="id", nullable=true)
     */
    protected $pricingPlan;
    
    public function getPricingPlan(): ?PricingPlanInterface
    {
        return $this->pricingPlan;
    }
    
    public function setPricingPlan( ?PricingPlanInterface $pricingPlan ): self
    {
        $this->pricingPlan = $pricingPlan;
        
        return $this;
    }
}