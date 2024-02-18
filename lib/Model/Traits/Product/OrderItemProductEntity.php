<?php namespace Vankosoft\CatalogBundle\Model\Traits\Product;

use Doctrine\ORM\Mapping as ORM;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;

trait OrderItemProductEntity
{
    /**
     * @var ProductInterface | null
     *
     * @ORM\ManyToOne(targetEntity="Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=true)
     */
    protected $product;
    
    /**
     * @var string | null
     * 
     * @ORM\Column(name="product_name", type="text", nullable=true)
     */
    protected $productName;
    
    public function getProduct(): ?ProductInterface
    {
        $product = $this->product;
        
        return $product;
    }
    
    public function setProduct(?ProductInterface $product): void
    {
        $this->product = $product;
    }
    
    public function getProductName(): ?string
    {
        return $this->productName ?: $this->product->getName();
    }
    
    public function setProductName(?string $productName): void
    {
        $this->productName = $productName;
    }
}