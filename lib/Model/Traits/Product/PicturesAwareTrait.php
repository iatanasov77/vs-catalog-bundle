<?php namespace Vankosoft\CatalogBundle\Model\Traits\Product;

use Doctrine\Common\Collections\Collection;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductPictureInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;

trait PicturesAwareTrait
{
    /**
     * @var Collection|ProductPictureInterface
     */
    protected $pictures;
    
    /**
     * @return Collection|ProductPictureInterface[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }
    
    /**
     * @param ProductPictureInterface $picture
     * @return ProductInterface
     */
    public function addPicture( ProductPictureInterface $picture ): ProductInterface
    {
        if ( ! $this->pictures->contains( $picture ) ) {
            $picture->setOwner( $this );
            $this->pictures[] = $picture;
        }
        
        return $this;
    }
    
    /**
     * @param ProductPictureInterface $picture
     * @return ProductInterface
     */
    public function removePicture( ProductPictureInterface $picture ): ProductInterface
    {
        if ( $this->pictures->contains( $picture ) ) {
            $this->pictures->removeElement( $picture );
        }
        
        return $this;
    }
}