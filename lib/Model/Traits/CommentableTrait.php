<?php namespace Vankosoft\CatalogBundle\Model\Traits;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Vankosoft\CatalogBundle\Model\Interfaces\CatalogCommentInterface;

trait CommentableTrait
{
    /**
     * Add Orm Mapping for this field where is used this trait
     * 
     * @var Collection|CatalogCommentInterface[]
     */
    protected $comments;
    
    /**
     * @return Collection|CatalogCommentInterface[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }
    
    public function addComment( CatalogCommentInterface $comment ): void
    {
        if ( ! $this->comments->contains( $comment ) ) {
            $this->comments[] = $comment;
        }
    }
    
    public function removeComment( CatalogCommentInterface $comment ): void
    {
        if ( $this->comments->contains( $comment ) ) {
            $this->comments->removeElement( $comment );
        }
    }
}