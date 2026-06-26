<?php namespace Vankosoft\CatalogBundle\Component;

class StarRatingCalculator
{
    /** @var int */
    protected $ratingScale = 5;
    
    public function setRatingScale( int $ratingScale ): void
    {
        $this->ratingScale = $ratingScale;
    }
    
    public function calculateRatingByLikes( $entity )
    {
        $repository    = $entityManager->getRepository( \get_class( $entity ) );
        $totalAverages = $repository->getAverageRatingByLikes();
        
        
        $starCount = $this->calculateStarCount( $entity );
        if ( $totalAverages['totalLikes'] == 0 || $starCount == 0 ) return 0;
        
        return $starCount - ( $totalAverages['totalDislikes'] / ( $totalAverages['totalLikes'] / $starCount ) );
    }
    
    protected function calculateStarCount( $entity ): int
    {
        $devision = $entity->getLikes() + $entity->getDislikes();
        if ( ! $devision ) {
            return 0;
        }
        $percent = $entity->getLikes() / $devision;
        
        return $percent;
    }
}