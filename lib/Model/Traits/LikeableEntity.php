<?php namespace Vankosoft\CatalogBundle\Model\Traits;

use Doctrine\ORM\Mapping as ORM;

trait LikeableEntity
{
    /** @var int */
    #[ORM\Column(name: "likes", type: "integer", options: ["default" => 0])]
    protected $likes = 0;
    
    /** @var int */
    #[ORM\Column(name: "dislikes", type: "integer", options: ["default" => 0])]
    protected $dislikes = 0;
    
    public function getLikes(): int
    {
        return $this->likes;
    }
    
    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }
    
    public function addLike(): void
    {
        $this->likes++;
    }
    
    public function getDislikes(): int
    {
        return $this->dislikes;
    }
    
    public function setDislikes(int $dislikes): void
    {
        $this->dislikes = $dislikes;
    }
    
    public function addDislike(): void
    {
        $this->dislikes++;
    }
}