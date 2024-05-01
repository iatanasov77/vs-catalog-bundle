<?php namespace Vankosoft\CatalogBundle\EventListener;

use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Sylius\Component\Review\Model\ReviewInterface;
use Vankosoft\CatalogBundle\Component\Review\ReviewableRatingUpdaterInterface;

final class ReviewChangeListener
{
    /** @var ReviewableRatingUpdaterInterface */
    private $averageRatingUpdater;
    
    public function __construct( ReviewableRatingUpdaterInterface $averageRatingUpdater )
    {
        $this->averageRatingUpdater = $averageRatingUpdater;
    }
    
    public function postPersist( LifecycleEventArgs $args )
    {
        $this->recalculateSubjectRating( $args );
    }
    
    public function postUpdate( LifecycleEventArgs $args )
    {
        $this->recalculateSubjectRating( $args );
    }
    
    public function postRemove( LifecycleEventArgs $args )
    {
        $this->recalculateSubjectRating( $args );
    }
    
    public function recalculateSubjectRating( LifecycleEventArgs $args ): void
    {
        $subject = $args->getObject();
        
        if ( ! $subject instanceof ReviewInterface ) {
            return;
        }
        
        $reviewSubject = $subject->getReviewSubject();
        
        if ( $args instanceof PostRemoveEventArgs ) {
            $reviewSubject->removeReview( $subject );
        }
        
        $this->averageRatingUpdater->update( $reviewSubject );
    }
}
