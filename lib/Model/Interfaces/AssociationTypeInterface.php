<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;

interface AssociationTypeInterface extends ResourceInterface
{
    public function getCode(): ?string;
    public function getName(): ?string;
}