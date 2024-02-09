<?php namespace Vankosoft\CatalogBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Vankosoft\ApplicationBundle\Model\Traits\TaxonLeafTrait;
use Vankosoft\PaymentBundle\Model\Interfaces\CurrencyInterface;
use Vankosoft\PaymentBundle\Model\Interfaces\OrderItemInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductPictureInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductFileInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\AssociationAwareInterface;
use Vankosoft\CatalogBundle\Model\Traits\AssociationAwareTrait;

class Product implements ProductInterface, AssociationAwareInterface
{
    use TaxonLeafTrait;
    use TimestampableTrait;
    use TranslatableTrait;
    use ToggleableTrait;    // About enabled field - $enabled (published)
    use AssociationAwareTrait;
    
    const UNLIMITED     = -1;
    const NOT_INSTOCK   = 0;
    
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
    
    /** @var integer */
    protected $inStock  = self::NOT_INSTOCK;
    
    /** @var integer */
    protected $price;
    
    /** @var CurrencyInterface */
    protected $currency;
    
    /** @var string */
    protected $tags   = '';
    
    /** @var Collection|ProductPictureInterface */
    protected $pictures;
    
    /** @var Collection|ProductFileInterface */
    protected $files;
    
    /** @var Collection|OrderItemInterface[] */
    protected $orderItems;
    
    /** @var Collection|ProductCategory[] */
    protected $categories;
    
    public function __construct()
    {
        $this->orderItems   = new ArrayCollection();
        $this->categories   = new ArrayCollection();
        $this->pictures     = new ArrayCollection();
        $this->files        = new ArrayCollection();
        
        /** @var ArrayCollection<array-key, AssociationInterface> $this->associations */
        $this->associations = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return Collection|ProductCategory[]
     */
    public function getCategories(): Collection
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
    
    public function getInStock(): int
    {
        return $this->inStock;
    }
    
    public function setInStock( int $inStock ): self
    {
        $this->inStock = $inStock;
        
        return $this;
    }
    
    /**
     * @return Collection|ProductPicture[]
     */
    public function getPictures(): Collection
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
    
    /**
     * @return Collection|ProductFile[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }
    
    public function addFile( ProductFile $file ): ProductInterface
    {
        if ( ! $this->files->contains( $file ) ) {
            $file->setOwner( $this );
            $this->files[] = $file;
        }
        
        return $this;
    }
    
    public function removeFile( ProductFile $file ): ProductInterface
    {
        if ( $this->files->contains( $file ) ) {
            $this->files->removeElement( $file );
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
    
    public function getTags()
    {
        return $this->tags;
    }
    
    public function setTags($tags)
    {
        $this->tags = $tags;
        
        return $this;
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
