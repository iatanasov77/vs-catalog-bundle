<?php namespace Vankosoft\CatalogBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vankosoft\ApplicationBundle\Model\Traits\TaxonDescendentTrait;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductCategoryInterface;

class ProductCategory implements ProductCategoryInterface
{
    use TaxonDescendentTrait;
    
    /** @var mixed */
    protected $id;
    
    /** @var ProductCategoryInterface */
    protected $parent;
    
    /** @var Collection|ProductCategory[] */
    protected $children;
    
    /** @var Collection|Product[] */
    protected $products;
    
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->products = new ArrayCollection();
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
    public function getParent(): ?ProductCategoryInterface
    {
        return $this->parent;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setParent(?ProductCategoryInterface $parent): ProductCategoryInterface
    {
        $this->parent = $parent;
        
        return $this;
    }
    
    public function getChildren(): Collection
    {
        return $this->children;
    }
    
    public function getProducts(): Collection
    {
        return $this->products;
    }
    
    public function addProduct( Product $product ): ProductCategoryInterface
    {
        if ( ! $this->products->contains( $product ) ) {
            $this->products[] = $product;
            $product->addCategory( $this );
        }
        
        return $this;
    }
    
    public function removeProduct( Product $product ): ProductCategoryInterface
    {
        if ( $this->products->contains( $product ) ) {
            $this->products->removeElement( $product );
            $product->removeCategory( $this );
        }
        
        return $this;
    }
}
