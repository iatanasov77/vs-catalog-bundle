<?php namespace Vankosoft\CatalogBundle\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository implements AssociationStrategyRepositoryInterface
{
    use AssociationStrategyRepositoryTrait;
    
    public function __construct( EntityManagerInterface $em, ClassMetadata $class )
    {
        parent::__construct( $em, $class );
    }
}
