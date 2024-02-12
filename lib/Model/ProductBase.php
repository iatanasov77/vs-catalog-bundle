<?php namespace Vankosoft\CatalogBundle\Model;

use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;
use Sylius\Component\Resource\Model\ToggleableTrait;

class ProductBase
{
    use TimestampableTrait;
    use TranslatableTrait;
    use ToggleableTrait;    // About enabled field - $enabled (published)
    
    const UNLIMITED     = -1;
    const NOT_INSTOCK   = 0;
    
    /** @var integer */
    protected $id;
    
    /** @var bool */
    protected $enabled = true;
    
    /** @var string */
    protected $slug;
    
    /** @var string */
    protected $locale;
    
    /** @var string */
    protected $name;
    
    /** @var string */
    protected $description;
    
    /** @var integer */
    protected $inStock  = self::NOT_INSTOCK;
    
    /** @var string */
    protected $tags   = '';
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getPublished(): ?bool
    {
        return $this->enabled;
    }
    
    public function setPublished( ?bool $published ): self
    {
        $this->enabled = (bool) $published;
        return $this;
    }
    
    public function isPublic(): bool
    {
        return $this->enabled;
    }
    
    public function isPublished(): bool
    {
        return $this->enabled;
    }
    
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    
    public function setSlug( $slug = null ): void
    {
        $this->slug = $slug;
        //return $this;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName( $name ): self
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function setDescription( $description ): self
    {
        $this->description = $description;
        
        return $this;
    }
    
    public function getInStock(): int
    {
        return $this->inStock;
    }
    
    public function setInStock( int $inStock ): self
    {
        $this->inStock = $inStock;
        
        return $this;
    }
    
    public function getTags()
    {
        return $this->tags;
    }
    
    public function setTags($tags)
    {
        $this->tags = $tags;
        
        return $this;
    }
    
    public function getLocale()
    {
        return $this->locale;
    }
    
    public function getTranslatableLocale()
    {
        return $this->locale;
    }
    
    public function setTranslatableLocale( $locale ): self
    {
        $this->locale = $locale;
        
        return $this;
    }
    
    public function getPublished(): ?bool
    {
        return $this->enabled;
    }
    
    public function setPublished( ?bool $published ): ProductInterface
    {
        $this->enabled = (bool) $published;
        return $this;
    }
    
    public function isPublished(): bool
    {
        return $this->isEnabled();
    }
    
    /*
     * @NOTE: Decalared abstract in TranslatableTrait
     */
    protected function createTranslation(): TranslationInterface
    {
        
    }
}