<?php namespace Vankosoft\CatalogBundle\Component\Review;

use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Review\Calculator\ReviewableRatingCalculatorInterface;
use Sylius\Component\Review\Model\ReviewableInterface;
use Sylius\Component\Review\Model\ReviewInterface;

class AverageRatingUpdater implements ReviewableRatingUpdaterInterface
{
    /** @var ReviewableRatingCalculatorInterface */
    private $averageRatingCalculator;
    
    /** @var ObjectManager */
    private $reviewSubjectManager;
    
    public function __construct(
        ReviewableRatingCalculatorInterface $averageRatingCalculator,
        ObjectManager $reviewSubjectManager
    ) {
        $this->averageRatingCalculator  = $averageRatingCalculator;
        $this->reviewSubjectManager     = $reviewSubjectManager;
    }
    
    public function update( ReviewableInterface $reviewSubject ): void
    {
        $this->modifyReviewSubjectAverageRating( $reviewSubject );
    }
    
    public function updateFromReview( ReviewInterface $review ): void
    {
        $this->modifyReviewSubjectAverageRating( $review->getReviewSubject() );
    }
    
    private function modifyReviewSubjectAverageRating( ReviewableInterface $reviewSubject ): void
    {
        $averageRating = $this->averageRatingCalculator->calculate( $reviewSubject );
        
        $reviewSubject->setAverageRating( $averageRating );
        
        $this->reviewSubjectManager->persist( $reviewSubject );
        $this->reviewSubjectManager->flush();
    }
}
