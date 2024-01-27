<?php namespace Vankosoft\CatalogBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductAssociationInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;

class ProductAssociation extends Association implements ProductAssociationInterface
{
    /** @var ProductInterface|null */
    protected $owner;
    
    /** @var Collection<array-key, ProductInterface> */
    protected $associatedProducts;
    
    public function __construct()
    {
        /** @var ArrayCollection<array-key, ProductInterface> $this->associatedProducts */
        $this->associatedProducts = new ArrayCollection();
    }
    
    public function getOwner(): ?ProductInterface
    {
        return $this->owner;
    }
    
    public function setOwner(?ProductInterface $owner): void
    {
        $this->owner = $owner;
    }
    
    public function getAssociatedProducts(): Collection
    {
        return $this->associatedProducts;
    }
    
    public function hasAssociatedProduct(ProductInterface $product): bool
    {
        return $this->associatedProducts->contains($product);
    }
    
    public function addAssociatedProduct(ProductInterface $product): void
    {
        if (!$this->hasAssociatedProduct($product)) {
            $this->associatedProducts->add($product);
        }
    }
    
    public function removeAssociatedProduct(ProductInterface $product): void
    {
        if ($this->hasAssociatedProduct($product)) {
            $this->associatedProducts->removeElement($product);
        }
    }
    
    public function clearAssociatedProducts(): void
    {
        $this->associatedProducts->clear();
    }
}