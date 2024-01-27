<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;

interface ProductAssociationInterface extends AssociationInterface
{
    public function getOwner(): ?ProductInterface;
    public function getAssociatedProducts(): Collection;
    public function hasAssociatedProduct(ProductInterface $product): bool;
    public function clearAssociatedProducts(): void;
}