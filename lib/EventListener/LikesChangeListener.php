<?php namespace Vankosoft\CatalogBundle\EventListener;

use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Sylius\Component\Review\Model\ReviewableInterface;
use Vankosoft\CatalogBundle\Component\Review\ReviewableRatingUpdaterInterface;

class LikesChangeListener
{
    /** @var ReviewableRatingUpdaterInterface */
    protected $averageRatingUpdater;
    
    public function __construct(
        ReviewableRatingUpdaterInterface $averageRatingUpdater
    ) {
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
        
        if ( ! $subject instanceof ReviewableInterface ) {
            return;
        }
        
        $this->averageRatingUpdater->update( $subject );
    }
}
