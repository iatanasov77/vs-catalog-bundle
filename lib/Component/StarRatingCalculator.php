<?php namespace Vankosoft\CatalogBundle\Component;

use Doctrine\Persistence\ManagerRegistry;

class StarRatingCalculator
{
    /** @var ManagerRegistry */
    protected $doctrine;
    
    /** @var int */
    protected $ratingScale = 5;
    
    public function __construct( ManagerRegistry $doctrine )
    {
        $this->doctrine = $doctrine;
    }
    
    public function setRatingScale( int $ratingScale ): void
    {
        $this->ratingScale = $ratingScale;
    }
    
    public function calculateRatingByLikes( $entity )
    {
        $repository    = $this->doctrine->getRepository( \get_class( $entity ) );
        $totalAverages = $repository->getAverageRatingByLikes();
        
        return $this->calculateRating( $entity, $totalAverages );
    }
    
    public function calculateAllRatingByLikes( string $entityClass )
    {
        $repository    = $this->doctrine->getRepository( $entityClass );
        $totalAverages = $repository->getAverageRatingByLikes();
        
        $allRatings = [];
        foreach ( $repository->findAll() as $item ) {
            $allRatings[$item->getId()] = $this->calculateRating( $item, $totalAverages );
        }
        
        return $allRatings;
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
    
    protected function calculateRating( $entity, $totalAverages )
    {
        $starCount = $this->calculateStarCount( $entity );
        if ( $totalAverages['totalLikes'] == 0 || $starCount == 0 ) return 0;
        
        return $starCount - ( $totalAverages['totalDislikes'] / ( $totalAverages['totalLikes'] / $starCount ) );
    }
}