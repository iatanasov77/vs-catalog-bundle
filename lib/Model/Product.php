<?php namespace Vankosoft\CatalogBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Vankosoft\ApplicationBundle\Model\Traits\TaxonLeafTrait;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;
use Vankosoft\PaymentBundle\Model\Interfaces\CurrencyInterface;
use Vankosoft\PaymentBundle\Model\Interfaces\OrderItemInterface;

class Product implements ProductInterface
{
    use TaxonLeafTrait;
    use TranslatableTrait;
    use ToggleableTrait;    // About enabled field - $enabled (published)
    
    /** @var integer */
    protected $id;
    
    /** @var string */
    protected $slug;
    
    /** @var string */
    protected $locale;
    
    /** @var string */
    protected $name;
    
    /** @var string */
    protected $description;
    
    /** @var string */
    protected $pictures;
    
    /** @var integer */
    protected $price;
    
    /** @var CurrencyInterface */
    protected $currency;
    
    /** @var Collection|OrderItemInterface[] */
    protected $orderItems;
    
    /** @var Collection|ProductCategory[] */
    protected $categories;
    
    public function __construct()
    {
        $this->orderItems   = new ArrayCollection();
        $this->categories   = new ArrayCollection();
        $this->pictures     = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return Collection|ProductCategory[]
     */
    public function getCategories()
    {
        return $this->categories;
    }
    
    public function addCategory( ProductCategory $category ): ProductInterface
    {
        if ( ! $this->categories->contains( $category ) ) {
            $this->categories[] = $category;
        }
        
        return $this;
    }
    
    public function removeCategory( ProductCategory $category ): ProductInterface
    {
        if ( $this->categories->contains( $category ) ) {
            $this->categories->removeElement( $category );
        }
        
        return $this;
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
    
    /**
     * @return Collection|ProductPicture[]
     */
    public function getPictures()
    {
        return $this->pictures;
    }
    
    public function addPicture( ProductPicture $picture ): ProductInterface
    {
        if ( ! $this->pictures->contains( $picture ) ) {
            $picture->setOwner( $this );
            $this->pictures[] = $picture;
        }
        
        return $this;
    }
    
    public function removePicture( ProductPicture $picture ): ProductInterface
    {
        if ( $this->pictures->contains( $picture ) ) {
            $this->pictures->removeElement( $picture );
        }
        
        return $this;
    }
    
    public function getPrice()
    {
        return $this->price;
    }
    
    public function setPrice( $price ): self
    {
        $this->price = $price;
        
        return $this;
    }
    
    public function getCurrency()
    {
        return $this->currency;
    }
    
    public function setCurrency( CurrencyInterface $currency )
    {
        $this->currency = $currency;
        
        return $this;
    }
    
    public function getCurrencyCode()
    {
        if ( $this->currency ) {
            return $this->currency->getCode();
        }
        
        return null;
    }
    
    public function getOrderItems()
    {
        return $this->orderItems;
    }
    
    public function getSubscriptionCode(): ?string
    {
        return null;
    }
    
    public function getSubscriptionPriority(): ?int
    {
        return null;
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
    
    public function isPublished()
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