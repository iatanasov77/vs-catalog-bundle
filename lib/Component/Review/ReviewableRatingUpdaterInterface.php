<?php namespace Vankosoft\CatalogBundle\Component\Review;

use Sylius\Component\Review\Model\ReviewableInterface;
use Sylius\Component\Review\Model\ReviewInterface;

interface ReviewableRatingUpdaterInterface
{
    public function update( ReviewableInterface $reviewSubject ): void;
    
    public function updateFromReview( ReviewInterface $review ): void;
}
