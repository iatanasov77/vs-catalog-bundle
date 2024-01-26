<?php namespace Vankosoft\CatalogBundle\Model;

use Vankosoft\CatalogBundle\Model\Interfaces\AssociationTypeInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class AssociationType implements AssociationTypeInterface, \Stringable
{
    use TranslatableTrait;
    use TimestampableTrait;
    
    /** @var mixed */
    protected $id;
    
    /** @var string|null */
    protected $code;
    
    /** @var string|null */
    protected $name;
    
    /** @var string */
    protected $locale;
    
    public function __toString(): string
    {
        return (string) $this->getName();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getCode(): ?string
    {
        return $this->code;
    }
    
    public function setCode(?string $code): self
    {
        $this->code = $code;
        
        return $this;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(?string $name): self
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function getTranslatableLocale(): ?string
    {
        return $this->locale;
    }
    
    public function setTranslatableLocale($locale): self
    {
        $this->locale = $locale;
        
        return $this;
    }
    
    /*
     * @NOTE: Decalared abstract in TranslatableTrait
     */
    protected function createTranslation(): TranslationInterface
    {
        
    }
}