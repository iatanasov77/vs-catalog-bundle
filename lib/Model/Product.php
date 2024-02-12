<?php namespace Vankosoft\CatalogBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vankosoft\ApplicationBundle\Model\Traits\TaxonLeafTrait;
use Vankosoft\PaymentBundle\Model\Interfaces\CurrencyInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;

/**
 * Product Traits
 */
use Vankosoft\CatalogBundle\Model\Traits\Product\CategoriesAwareTrait;
use Vankosoft\CatalogBundle\Model\Traits\Product\PicturesAwareTrait;
use Vankosoft\CatalogBundle\Model\Traits\Product\FilesAwareTrait;
use Vankosoft\CatalogBundle\Model\Traits\AssociationAwareTrait;
use Vankosoft\CatalogBundle\Model\Traits\ReviewableTrait;
use Vankosoft\CatalogBundle\Model\Traits\CommentableTrait;
use Vankosoft\CatalogBundle\Model\Interfaces\AssociationAwareInterface;

use Vankosoft\PaymentBundle\Model\Traits\PayableObjectTrait;

/**
 * This is a Final Product Implementation
 * In your projects you can extend it OR You want exclude some Fields,
 * You can Create Your Own Product Entity that Extends ProductBase Model and 
 * Implement Your Own Product Interface that extends needed Interfaces
 */
class Product extends ProductBase implements ProductInterface, AssociationAwareInterface
{
    use CategoriesAwareTrait;
    use PicturesAwareTrait;
    use FilesAwareTrait;
    use AssociationAwareTrait;
    use ReviewableTrait;
    use CommentableTrait;
    use PayableObjectTrait;
    use TaxonLeafTrait;
    
    public function __construct()
    {
        $this->categories   = new ArrayCollection();
        $this->pictures     = new ArrayCollection();
        $this->files        = new ArrayCollection();
        
        /** @var ArrayCollection<array-key, AssociationInterface> $this->associations */
        $this->associations = new ArrayCollection();
        
        $this->orderItems   = new ArrayCollection();
    }
    
    
    
    public function getSubscriptionCode(): ?string
    {
        return null;
    }
    
    public function getSubscriptionPriority(): ?int
    {
        return null;
    }
}
