<?php namespace Vankosoft\CatalogBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Webmozart\Assert\Assert;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

use Vankosoft\CatalogBundle\Model\Interfaces\ProductAssociationInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\AssociationTypeInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;
use Vankosoft\CatalogBundle\Repository\ProductRepository;

final class ProductsToProductAssociationsTransformer implements DataTransformerInterface
{
    /** @var FactoryInterface */
    private $productAssociationFactory;
    
    /** @var ProductRepository */
    private $productRepository;
    
    /** @var RepositoryInterface */
    private $productAssociationTypeRepository;
    
    /** @var Collection<array-key, ProductAssociationInterface> */
    private ?Collection $productAssociations = null;
    
    public function __construct(
        FactoryInterface $productAssociationFactory,
        ProductRepository $productRepository,
        RepositoryInterface $productAssociationTypeRepository
    ) {
        $this->productAssociationFactory        = $productAssociationFactory;
        $this->productRepository                = $productRepository;
        $this->productAssociationTypeRepository = $productAssociationTypeRepository;
    }
    
    public function transform( $value )
    {
        $this->setProductAssociations( $value );
        
        if ( null === $value ) {
            return '';
        }
        
        $values = [];
        
        /** @var ProductAssociationInterface $productAssociation */
        foreach ( $value as $productAssociation ) {
            $productCodes   = $this->getCodesFromProducts( $productAssociation->getAssociatedProducts() );
            $values[$productAssociation->getType()->getCode()]  = $productCodes;
        }
        
        return $values;
    }
    
    public function reverseTransform( $value ): ?Collection
    {
        if ( null === $value || '' === $value || !is_array( $value ) ) {
            return null;
        }
        
        /** @var Collection<array-key, ProductAssociationInterface> $productAssociations */
        $productAssociations = new ArrayCollection();
        
        foreach ( $value as $productAssociationTypeCode => $productCodes ) {
            if ( null === $productCodes ) {
                continue;
            }
            
            /** @var ProductAssociationInterface $productAssociation */
            $productAssociation = $this->getProductAssociationByTypeCode( (string) $productAssociationTypeCode );
            $this->setAssociatedProductsByProductCodes( $productAssociation, $productCodes );
            $productAssociations->add( $productAssociation );
        }
        
        $this->setProductAssociations( null );
        
        return $productAssociations;
    }
    
    private function getCodesFromProducts( Collection $products ): array
    {
        $codes = [];
        
        /** @var ProductInterface $product */
        foreach ( $products as $product ) {
            $codes[] = $product->getCode();
        }
        
        return $codes;
    }
    
    private function getProductAssociationByTypeCode( string $productAssociationTypeCode ): ProductAssociationInterface
    {
        foreach ( $this->productAssociations as $productAssociation ) {
            if ( $productAssociationTypeCode === $productAssociation->getType()->getCode() ) {
                return $productAssociation;
            }
        }
        
        /** @var AssociationTypeInterface $productAssociationType */
        $productAssociationType = $this->productAssociationTypeRepository->findOneBy([
            'code' => $productAssociationTypeCode,
        ]);
        
        /** @var ProductAssociationInterface $productAssociation */
        $productAssociation = $this->productAssociationFactory->createNew();
        $productAssociation->setType( $productAssociationType );
        
        return $productAssociation;
    }
    
    private function setAssociatedProductsByProductCodes(
        ProductAssociationInterface $productAssociation,
        array $productCodes
    ): void {
        $products = $this->productRepository->findBy( ['slug' => $productCodes] );
        
        $productAssociation->clearAssociatedProducts();
        foreach ( $products as $product ) {
            Assert::isInstanceOf( $product, ProductInterface::class );
            $productAssociation->addAssociatedProduct( $product );
        }
    }
    
    private function setProductAssociations( ?Collection $productAssociations ): void
    {
        $this->productAssociations  = $productAssociations;
    }
}
