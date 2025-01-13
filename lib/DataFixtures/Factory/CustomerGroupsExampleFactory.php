<?php namespace Vankosoft\CatalogBundle\DataFixtures\Factory;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\AbstractExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\ExampleFactoryInterface;
use Vankosoft\ApplicationBundle\Component\SlugGenerator;

use Sylius\Component\Customer\Model\CustomerGroupInterface;

final class CustomerGroupsExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /** @var FactoryInterface */
    private $customerGroupsFactory;
    
    /** @var OptionsResolver */
    private $optionsResolver;
    
    /** @var RepositoryInterface */
    private $taxonomyRepository;
    
    /** @var FactoryInterface */
    private $taxonFactory;
    
    /** @var SlugGenerator */
    private $slugGenerator;
    
    public function __construct(
        FactoryInterface $customerGroupsFactory,
        
        RepositoryInterface $taxonomyRepository,
        FactoryInterface $taxonFactory,
        SlugGenerator $slugGenerator
    ) {
        $this->customerGroupsFactory    = $customerGroupsFactory;
        
        $this->optionsResolver          = new OptionsResolver();
        $this->configureOptions( $this->optionsResolver );
        
        $this->taxonomyRepository       = $taxonomyRepository;
        $this->taxonFactory             = $taxonFactory;
        $this->slugGenerator            = $slugGenerator;
    }
    
    public function create( array $options = [] ): CustomerGroupInterface
    {
        $options                    = $this->optionsResolver->resolve( $options );
        
        $taxonomyRootTaxonEntity    = $this->taxonomyRepository->findByCode( $options['taxonomy_code'] )->getRootTaxon();
        $entity                     = $this->customerGroupsFactory->createNew();
        
        $taxonEntity                = $this->taxonFactory->createNew();
        
        //$slug                       = $this->slugGenerator->generate( $options['title'] );
        $slug                       = $options['taxon_code'];
        
        $taxonEntity->setCurrentLocale( $options['locale'] );
        $taxonEntity->setCode( $slug );
        $taxonEntity->getTranslation()->setName( $options['title'] );
        $taxonEntity->getTranslation()->setSlug( $slug );
        $taxonEntity->getTranslation()->setTranslatable( $taxonEntity );
        
        $taxonEntity->setParent( $taxonomyRootTaxonEntity );
        $entity->setTaxon( $taxonEntity );
        
        return $entity;
    }
    
    protected function configureOptions( OptionsResolver $resolver ): void
    {
        $resolver
            ->setDefault( 'title', null )
            ->setAllowedTypes( 'title', ['string'] )
            
            ->setDefault( 'locale', 'en_US' )
            ->setAllowedTypes( 'locale', ['string'] )
            
            ->setDefault( 'taxonomy_code', null )
            ->setAllowedTypes( 'taxonomy_code', ['string'] )
            
            ->setDefault( 'taxon_code', null )
            ->setAllowedTypes( 'taxon_code', ['string'] )
        ;
    }
}
