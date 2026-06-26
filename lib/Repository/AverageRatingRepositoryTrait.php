<?php namespace Vankosoft\CatalogBundle\Repository;

trait AverageRatingRepositoryTrait
{
    public function getAverageRatingByLikes(): array
    {
        $totalLikes = $this->createQueryBuilder( 'ar' )->select( 'SUM( ar.likes ) AS totalSum' )
                        ->getQuery()
                        ->getSingleScalarResult();
        
        $totalDislikes = $this->createQueryBuilder( 'ar' )->select( 'SUM( ar.dislikes ) AS totalSum' )
                        ->getQuery()
                        ->getSingleScalarResult();
        
        return [
            'totalLikes'    => $totalLikes,
            'totalDislikes' => $totalDislikes,
        ];
    }
}
