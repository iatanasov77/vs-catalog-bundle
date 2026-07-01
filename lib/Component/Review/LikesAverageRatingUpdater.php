<?php namespace Vankosoft\CatalogBundle\Component\Review;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Review\Model\ReviewableInterface;
use Sylius\Component\Review\Model\ReviewInterface;

class LikesAverageRatingUpdater implements ReviewableRatingUpdaterInterface
{
    /** @var ObjectManager */
    protected $reviewSubjectManager;
    
    public function __construct(
        ObjectManager $reviewSubjectManager
    ) {
        $this->reviewSubjectManager = $reviewSubjectManager;
    }
    
    public function update( ReviewableInterface $reviewSubject ): void
    {
        $this->modifyReviewSubjectAverageRating( $reviewSubject );
    }
    
    public function updateFromReview( ReviewInterface $review ): void
    {
        $this->modifyReviewSubjectAverageRating( $review->getReviewSubject() );
    }
    
    protected function modifyReviewSubjectAverageRating( ReviewableInterface $reviewSubject ): void
    {
        $averageRating = 0;
        $reviewSubject->setAverageRating( $averageRating );
        
        $this->reviewSubjectManager->persist( $reviewSubject );
        $this->reviewSubjectManager->flush();
    }
}
