<?php namespace Vankosoft\CatalogBundle\DataFixtures\Fixture;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\AbstractResourceFixture;

class AssociationTypesFixture extends AbstractResourceFixture
{
    public function getName(): string
    {
        return 'association_types';
    }
    
    protected function configureResourceNode( ArrayNodeDefinition $resourceNode ): void
    {
        $resourceNode
            ->children()
                ->scalarNode( 'locale' )->end()
                ->scalarNode( 'associationStrategy' )->end()
                ->scalarNode( 'code' )->end()
                ->scalarNode( 'name' )->end()
        ;
    }
}