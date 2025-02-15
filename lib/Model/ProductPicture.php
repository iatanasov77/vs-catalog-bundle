<?php namespace Vankosoft\CatalogBundle\Model;

use Vankosoft\CmsBundle\Model\File;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductPictureInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;

class ProductPicture extends File implements ProductPictureInterface
{
    /** @var ProductInterface | null */
    protected $owner;
    
    /** @var string */
    protected $code;
    
    public function getProduct()
    {
        return $this->owner;
    }
    
    public function setProduct( Product $product ): self
    {
        $this->setOwner( $product);
        
        return $this;
    }
    
    public function getCode()
    {
        return $this->code;
    }
    
    public function setCode( $code ): self
    {
        $this->code = $code;
        
        return $this;
    }
}
