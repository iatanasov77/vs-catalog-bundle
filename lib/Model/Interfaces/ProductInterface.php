<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;
use Vankosoft\PaymentBundle\Model\Interfaces\PayableObjectInterface;
use Vankosoft\ApplicationBundle\Model\Interfaces\TaxonLeafInterface;

interface ProductInterface extends ResourceInterface, PayableObjectInterface, TaxonLeafInterface
{
    public function isPublished(): bool;
    public function getInStock(): int;
    public function getSlug(): ?string;
    public function getDescription(): ?string;
    
    public function getCategories(): Collection;
    public function getPictures(): Collection;
    public function getFiles(): Collection;
}
