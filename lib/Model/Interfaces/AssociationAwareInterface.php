<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;

interface AssociationAwareInterface
{
    public function getAssociations(): Collection;
    public function addAssociation(AssociationInterface $association): void;
    public function removeAssociation(AssociationInterface $association): void;
    public function hasAssociation(AssociationInterface $association): bool;
}