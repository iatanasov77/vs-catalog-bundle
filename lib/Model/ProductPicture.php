<?php namespace Vankosoft\CatalogBundle\Model;

use Vankosoft\CmsBundle\Model\File;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductPictureInterface;

class ProductPicture extends File implements ProductPictureInterface
{
    protected $owner;
    
    public function getProduct()
    {
        return $this->owner;
    }
    
    public function setProduct( Product $product ): self
    {
        $this->setOwner( $product);
        
        return $this;
    }
}
