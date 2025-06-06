<?php namespace Vankosoft\CatalogBundle\Model\Traits;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Vankosoft\CatalogBundle\Model\Interfaces\CatalogCommentInterface;

trait CommentableEntity
{
    /** @var Collection|CatalogCommentInterface[] */
    #[ORM\OneToMany(targetEntity: CatalogCommentInterface::class, mappedBy: "commentSubject", indexBy: "id", cascade: ["all"], orphanRemoval: true)]
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