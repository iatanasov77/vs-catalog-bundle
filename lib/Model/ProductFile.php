<?php namespace Vankosoft\CatalogBundle\Model;

use Vankosoft\CmsBundle\Model\File;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductFileInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;

class ProductFile extends File implements ProductFileInterface
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
