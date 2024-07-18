<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;
use Doctrine\Common\Collections\Collection;
use Vankosoft\ApplicationBundle\Model\Interfaces\TaxonDescendentInterface;
use Vankosoft\ApplicationBundle\Model\Interfaces\TaxonInterface;

interface PricingPlanCategoryInterface extends ResourceInterface, TaxonDescendentInterface
{
    public function getTaxon(): ?TaxonInterface;
    public function getParent();
    public function getChildren(): Collection;
    
    public function getPlans(): Collection;
}