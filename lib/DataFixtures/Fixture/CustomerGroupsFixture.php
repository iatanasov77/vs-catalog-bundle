<?php namespace Vankosoft\CatalogBundle\DataFixtures\Fixture;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\AbstractResourceFixture;

final class CustomerGroupsFixture extends AbstractResourceFixture
{
    public function getName(): string
    {
        return 'customer_groups';
    }
    
    protected function configureResourceNode( ArrayNodeDefinition $resourceNode ): void
    {
        $resourceNode
            ->children()
                ->scalarNode( 'locale' )->end()
                ->scalarNode( 'title' )->end()
                ->scalarNode( 'description' )->end()
                ->scalarNode( 'taxonomy_code' )->end()
                ->variableNode( 'translations' )->cannotBeEmpty()->defaultValue( [] )->end()
        ;
    }
}
