<?php namespace Vankosoft\CatalogBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Sylius\Component\Review\Model\ReviewInterface;
use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationInterface;

interface ProductReviewRepositoryInterface extends RepositoryInterface
{
    /**
     * @return array|ReviewInterface[]
     */
    public function findLatestByProductId( $productId, int $count ): array;
    
    /**
     * @return array|ReviewInterface[]
     */
    public function findAcceptedByProductSlugAndChannel( string $slug, string $locale, ApplicationInterface $application ): array;
    
    public function createQueryBuilderByProductCode( string $locale, string $productCode ): QueryBuilder;
    
    public function findOneByIdAndProductCode( $id, string $productCode ): ?ReviewInterface;
}
