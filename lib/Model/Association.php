<?php namespace Vankosoft\CatalogBundle\Model;

use Sylius\Component\Resource\Model\TimestampableTrait;
use Vankosoft\CatalogBundle\Model\Interfaces\AssociationInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\AssociationTypeInterface;

class Association implements AssociationInterface
{
    use TimestampableTrait;
    
    /** @var mixed */
    protected $id;
    
    /** @var AssociationTypeInterface | null */
    protected $type;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getType(): ?AssociationTypeInterface
    {
        return $this->type;
    }
    
    public function setType(?AssociationTypeInterface $type): void
    {
        $this->type = $type;
    }
}