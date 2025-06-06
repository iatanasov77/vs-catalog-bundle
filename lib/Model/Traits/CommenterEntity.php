<?php namespace Vankosoft\CatalogBundle\Model\Traits;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Vankosoft\CatalogBundle\Model\Interfaces\CatalogCommentInterface;

trait CommenterEntity
{
    /** @var Collection | CatalogComment[] */
    #[ORM\OneToMany(targetEntity: CatalogCommentInterface::class, mappedBy: "author", cascade: ["persist", "remove"], orphanRemoval: true)]
    protected $comments;
    
    /**
     * @return Collection|CatalogCommentInterface[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }
    
    public function setComments( Collection $comments ): self
    {
        $this->comments  = $comments;
        
        return $this;
    }
    
    public function addComment( CatalogCommentInterface $comment ): self
    {
        if ( ! $this->comments->contains( $comment ) ) {
            $this->comments[]    = $comment;
            $comment->setAuthor( $this );
        }
        
        return $this;
    }
    
    public function removeComment( CatalogCommentInterface $comment ): self
    {
        if ( $this->comments->contains( $comment ) ) {
            $this->comments->removeElement( $comment );
            $comment->setAuthor( null );
        }
        
        return $this;
    }
}
