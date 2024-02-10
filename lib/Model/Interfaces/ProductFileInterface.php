<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ProductFileInterface extends ResourceInterface
{
    public function getProduct();
    public function getCode();
}
