<?php namespace Vankosoft\CatalogBundle\Model\Traits;

use Doctrine\ORM\Mapping as ORM;
use Vankosoft\PaymentBundle\Model\Interfaces\PayableObjectInterface;
use Vankosoft\PaymentBundle\Component\PayableObject;
use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanSubscriptionInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;

trait PayableObjectAwareEntity
{
    /**
     * 'object' is for paid services
     * 
     * @var PricingPlanSubscriptionInterface
     * 
     * @ORM\ManyToOne(targetEntity="Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanSubscriptionInterface", inversedBy="orderItem", cascade={"all"})
     * @ORM\JoinColumn(name="subscription_id", referencedColumnName="id", nullable=true)
     */
    protected $subscription;
 
    /**
     * @var ProductInterface
     * 
     * @ORM\ManyToOne(targetEntity="Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface", inversedBy="orderItems", cascade={"all"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=true)
     */
    protected $product;
    
    public function getSubscription(): ?PricingPlanSubscriptionInterface
    {
        return $this->subscription;
    }
    
    public function setSubscription( PricingPlanSubscriptionInterface $subscription ): self
    {
        $this->subscription         = $subscription;
        $this->payableObjectType    = get_class( $subscription );
        
        return $this;
    }
    
    public function getProduct(): ?ProductInterface
    {
        return $this->product;
    }
    
    public function setProduct( ProductInterface $product ): self
    {
        $this->product              = $product;
        $this->payableObjectType    = get_class( $product );
        
        return $this;
    }
    
    public function getObject(): PayableObjectInterface
    {
        switch ( $this->getPayableObjectType() ) {
            case 'App\Entity\Catalog\PricingPlan':
                return $this->getSubscription();
                break;
            case 'App\Entity\Catalog\Product':
                return $this->getProduct();
                break;
            default:
                throw new \Exception( 'Wrong Order Item !!!' );
        }
    }
}