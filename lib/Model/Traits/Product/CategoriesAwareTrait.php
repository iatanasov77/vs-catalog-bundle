<?php namespace Vankosoft\CatalogBundle\Model\Traits\Product;

use Doctrine\Common\Collections\Collection;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductCategoryInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;

trait CategoriesAwareTrait
{
    /**
     * @var Collection|ProductCategoryInterface[]
     */
    protected $categories;
    
    /**
     * @return Collection|ProductCategoryInterface[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }
    
    /**
     * @param ProductCategoryInterface $category
     * @return ProductInterface
     */
    public function addCategory( ProductCategoryInterface $category ): ProductInterface
    {
        if ( ! $this->categories->contains( $category ) ) {
            $this->categories[] = $category;
        }
        
        return $this;
    }
    
    /**
     * @param ProductCategoryInterface $category
     * @return ProductInterface
     */
    public function removeCategory( ProductCategoryInterface $category ): ProductInterface
    {
        if ( $this->categories->contains( $category ) ) {
            $this->categories->removeElement( $category );
        }
        
        return $this;
    }
}