<?php namespace Vankosoft\CatalogBundle\Model\Traits;

use Doctrine\Common\Collections\Collection;
use Vankosoft\CatalogBundle\Model\Interfaces\AssociationInterface;

trait AssociationAwareTrait
{
    /** @var Collection<array-key, AssociationInterface> */
    protected $associations;
    
    public function getAssociations(): Collection
    {
        return $this->associations;
    }
    
    public function addAssociation(AssociationInterface $association): void
    {
        if (!$this->hasAssociation($association)) {
            $this->associations->add($association);
            $association->setOwner($this);
        }
    }
    
    public function removeAssociation(AssociationInterface $association): void
    {
        if ($this->hasAssociation($association)) {
            $association->setOwner(null);
            $this->associations->removeElement($association);
        }
    }
    
    public function hasAssociation(AssociationInterface $association): bool
    {
        return $this->associations->contains($association);
    }
    
    public function getCode(): string
    {
        return $this->slug;
    }
}