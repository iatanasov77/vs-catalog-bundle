<?php namespace Vankosoft\CatalogBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vankosoft\ApplicationBundle\Model\Traits\TaxonDescendentTrait;

use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanCategoryInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanInterface;

class PricingPlanCategory implements PricingPlanCategoryInterface
{
    use TaxonDescendentTrait;
    
    /** @var mixed */
    protected $id;
    
    /** @var PricingPlanCategoryInterface */
    protected $parent;
    
    /** @var Collection|PricingPlanCategory[] */
    protected $children;
    
    /** @var Collection|PricingPlanInterface[] */
    protected $plans;
    
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->plans    = new ArrayCollection();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setParent( ?PricingPlanCategoryInterface $parent ): PricingPlanCategoryInterface
    {
        $this->parent = $parent;
        
        return $this;
    }
    
    public function getChildren(): Collection
    {
        return $this->children;
    }
    
    /**
     * @return Collection|PricingPlanInterface[]
     */
    public function getPlans(): Collection
    {
        return $this->plans;
    }
    
    public function addPlan( PricingPlanInterface $plan ): PricingPlanCategoryInterface
    {
        if ( ! $this->plans->contains( $plan ) ) {
            $this->plans[] = $plan;
            $plan->addCategory( $this );
        }
        
        return $this;
    }
    
    public function removePlan( PricingPlanInterface $plan ): PricingPlanCategoryInterface
    {
        if ( $this->plans->contains( $plan ) ) {
            $this->plans->removeElement( $plan );
            $plan->removeCategory( $this );
        }
        
        return $this;
    }
    
    public function getEnabledPlans(): Collection
    {
        return $this->getPlans()->filter( function( PricingPlanInterface $plan )
        {
            return $plan->isEnabled();
        });
    }
    
    public function __toString()
    {
        return $this->taxon ? $this->taxon->getName() : '';
    }
}