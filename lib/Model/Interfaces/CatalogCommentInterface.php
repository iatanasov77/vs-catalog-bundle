<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;

interface CatalogCommentInterface extends ResourceInterface
{
    public function getAuthor(): ?CommenterInterface;
    public function getCommentSubject(): ?CommentableInterface;
    public function getComment(): ?string;
    public function getLikes(): int;
    public function addLike(): void;
    public function getDislikes(): int;
    public function addDislike(): void;
}