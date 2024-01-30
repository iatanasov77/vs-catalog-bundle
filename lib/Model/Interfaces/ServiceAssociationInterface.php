<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;

interface ServiceAssociationInterface extends AssociationInterface
{
    public function getOwner(): ?ContentServiceInterface;
    public function getAssociatedProducts(): Collection;
    public function hasAssociatedProduct(ContentServiceInterface $product): bool;
    public function clearAssociatedProducts(): void;
}