<?php namespace Vankosoft\CatalogBundle\Repository;

use Vankosoft\CatalogBundle\Component\AssociationStrategy;
use Vankosoft\CatalogBundle\Component\Exception\AssociationStrategyException;

trait AssociationStrategyRepositoryTrait
{
    public function getAssociations( $entity, string $strategy = AssociationStrategy::STRATEGY_RANDOM )
    {
        if ( ! ( $entity instanceof AssociationAwareInterface ) ) {
            throw new AssociationStrategyException( 'Unsupported Association Strategy !' );
        }
        
        switch ( $strategy ) {
            case AssociationStrategy::STRATEGY_RANDOM:
                return $this->getRandomAssociations( 10 );
                break;
            default:
                return $entity->getAssociations();
        }
    }
    
    /**
     * https://digitalfortress.tech/php/get-random-rows-in-doctrine/
     *
     * @param int $randCount
     * @return Query Result
     */
    public function getRandomAssociations( int $randCount )
    {
        $em     = $this->getEntityManager();
        $conn   = $em->getConnection();
        
        // get random ID's using RAW SQL
        $sql    = \sprintf( "SELECT id from %s ORDER BY RAND() LIMIT %s", $this->_class->table['name'], $randCount );
        $stmt   = $conn->prepare( $sql );
        $result = $stmt->execute();
        
        $randomIds = array();
        while ( $val = $result->fetch() ) {
            $randomIds[]    = $val['id'];
        }
        
        // native SQL in doctrine to load associated objects
        $sql    = \sprintf( "SELECT tt FROM %s tt WHERE tt.id in (:ids)", $this->_class->name );
        $query = $em->createQuery( $sql )->setParameter( 'ids', $randomIds );
        
        return $query->getResult();
    }
}