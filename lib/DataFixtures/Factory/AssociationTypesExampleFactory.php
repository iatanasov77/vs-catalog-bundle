<?php namespace Vankosoft\CatalogBundle\DataFixtures\Factory;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\AbstractExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\ExampleFactoryInterface;

use Vankosoft\CatalogBundle\Model\Interfaces\AssociationTypeInterface;

final class AssociationTypesExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /** @var FactoryInterface */
    private $associationTypesFactory;
    
    /** @var OptionsResolver */
    private $optionsResolver;
    
    public function __construct(
        FactoryInterface $associationTypesFactory
    ) {
        $this->associationTypesFactory  = $associationTypesFactory;
        
        $this->optionsResolver          = new OptionsResolver();
        $this->configureOptions( $this->optionsResolver );
    }
    
    public function create( array $options = [] ): AssociationTypeInterface
    {
        $options    = $this->optionsResolver->resolve( $options );
        
        $entity     = $this->associationTypesFactory->createNew();
        
        $entity->setTranslatableLocale( $options['locale'] );
        $entity->setAssociationStrategy( $options['associationStrategy'] );
        $entity->setCode( $options['code'] );
        $entity->setName( $options['name'] );
        
        return $entity;
    }
    
    protected function configureOptions( OptionsResolver $resolver ): void
    {
        $resolver
            ->setDefault( 'locale', null )
            ->setAllowedTypes( 'locale', ['string'] )
        
            ->setDefault( 'associationStrategy', null )
            ->setAllowedTypes( 'associationStrategy', ['string'] )

            ->setDefault( 'code', null )
            ->setAllowedTypes( 'code', ['string'] )
            
            ->setDefault( 'name', null )
            ->setAllowedTypes( 'name', ['string'] )
        ;
    }
}