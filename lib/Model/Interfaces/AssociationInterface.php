<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;

interface AssociationInterface extends ResourceInterface
{
    public function getType(): ?AssociationTypeInterface;
}