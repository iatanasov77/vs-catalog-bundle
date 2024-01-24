<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;
use Vankosoft\PaymentBundle\Model\Interfaces\PayableObjectInterface;
use Vankosoft\ApplicationBundle\Model\Interfaces\TaxonLeafInterface;

interface ProductInterface extends ResourceInterface, PayableObjectInterface, TaxonLeafInterface
{
    
}
