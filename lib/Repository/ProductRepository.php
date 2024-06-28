<?php namespace Vankosoft\CatalogBundle\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

class ProductRepository extends EntityRepository implements AssociationStrategyRepositoryInterface
{
    use AssociationStrategyRepositoryTrait;
    
    public function __construct( EntityManagerInterface $em, ClassMetadata $class )
    {
        parent::__construct( $em, $class );
    }
    
    /**
     * @TODO Should Made to Fech All Products With Tag 'Special'
     */
    public function getFeaturedProducts()
    {
        $em     = $this->getEntityManager();
        $conn   = $em->getConnection();
        
        // get random ID's using RAW SQL
        $sql    = \sprintf( "SELECT id from %s ORDER BY RAND() LIMIT %s", $this->_class->table['name'], 10 );
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
    
    /**
     * https://digitalfortress.tech/php/get-random-rows-in-doctrine/
     *
     * @param int $randCount
     * @return Query Result
     */
    public function getRandomProducts( int $randCount )
    {
        $em     = $this->getEntityManager();
        $conn   = $em->getConnection();
        
        // get random ID's using RAW SQL
        $sql    = 'SELECT id from VSCAT_Products ORDER BY RAND() LIMIT ' . $randCount;
        $stmt   = $conn->prepare( $sql );
        $result = $stmt->execute();
        
        $randomIds = array();
        while ( $val = $result->fetch() ) {
            $randomIds[]    = $val['id'];
        }
        
        // native SQL in doctrine to load associated objects
        $query = $em->createQuery( "SELECT tt FROM App\Entity\Catalog\Product tt WHERE tt.id in (:ids)" )->setParameter( 'ids', $randomIds );
        
        return $query->getResult();
    }
}
