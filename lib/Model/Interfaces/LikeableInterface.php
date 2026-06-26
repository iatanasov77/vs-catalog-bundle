<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

interface LikeableInterface
{
    public function getLikes(): int;
    public function setLikes(int $likes): void;
    public function addLike(): void;
    public function getDislikes(): int;
    public function setDislikes(int $dislikes): void;
    public function addDislike(): void;
}