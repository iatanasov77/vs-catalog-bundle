<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ProductPictureInterface extends ResourceInterface
{
    public function getProduct();
    public function getCode();
}
