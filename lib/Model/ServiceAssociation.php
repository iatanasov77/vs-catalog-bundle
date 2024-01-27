<?php namespace Vankosoft\CatalogBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vankosoft\CatalogBundle\Model\Interfaces\ServiceAssociationInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ContentServiceInterface;

class ServiceAssociation extends Association implements ServiceAssociationInterface
{
    /** @var ContentServiceInterface | null */
    protected $owner;
    
    /** @var Collection<array-key, ContentServiceInterface> */
    protected $associatedProducts;
    
    public function __construct()
    {
        /** @var ArrayCollection<array-key, ContentServiceInterface> $this->associatedProducts */
        $this->associatedProducts = new ArrayCollection();
    }
    
    public function getOwner(): ?ContentServiceInterface
    {
        return $this->owner;
    }
    
    public function setOwner(?ContentServiceInterface $owner): void
    {
        $this->owner = $owner;
    }
    
    public function getAssociatedProducts(): Collection
    {
        return $this->associatedProducts;
    }
    
    public function hasAssociatedProduct(ContentServiceInterface $product): bool
    {
        return $this->associatedProducts->contains($product);
    }
    
    public function addAssociatedProduct(ContentServiceInterface $product): void
    {
        if (!$this->hasAssociatedProduct($product)) {
            $this->associatedProducts->add($product);
        }
    }
    
    public function removeAssociatedProduct(ContentServiceInterface $product): void
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