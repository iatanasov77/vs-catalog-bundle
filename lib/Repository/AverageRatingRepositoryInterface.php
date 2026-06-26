<?php namespace Vankosoft\CatalogBundle\Repository;

interface AverageRatingRepositoryInterface
{
    public function getAverageRatingByLikes(): array;
}
