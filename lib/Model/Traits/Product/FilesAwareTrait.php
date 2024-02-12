<?php namespace Vankosoft\CatalogBundle\Model\Traits\Product;

use Doctrine\Common\Collections\Collection;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductFileInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;

trait FilesAwareTrait
{
    /**
     * @var Collection|ProductFileInterface
     */
    protected $files;
    
    /**
     * @return Collection|ProductFileInterface[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }
    
    /**
     * @param ProductFileInterface $file
     * @return ProductInterface
     */
    public function addFile( ProductFileInterface $file ): ProductInterface
    {
        if ( ! $this->files->contains( $file ) ) {
            $file->setOwner( $this );
            $this->files[] = $file;
        }
        
        return $this;
    }
    
    /**
     * @param ProductFileInterface $file
     * @return ProductInterface
     */
    public function removeFile( ProductFileInterface $file ): ProductInterface
    {
        if ( $this->files->contains( $file ) ) {
            $this->files->removeElement( $file );
        }
        
        return $this;
    }
}