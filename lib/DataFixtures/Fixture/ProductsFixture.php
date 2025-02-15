<?php namespace Vankosoft\CatalogBundle\DataFixtures\Fixture;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\AbstractResourceFixture;

final class ProductsFixture extends AbstractResourceFixture
{
    public function getName(): string
    {
        return 'products';
    }
    
    protected function configureResourceNode( ArrayNodeDefinition $resourceNode ): void
    {
        $resourceNode
            ->children()
                
                ->scalarNode( 'name' )->end()
                ->scalarNode( 'description' )->end()
                ->scalarNode( 'category_code' )->end()
                ->scalarNode( 'locale' )->end()
                ->booleanNode( 'published' )->defaultTrue()->end()
                ->scalarNode( 'price' )->end()
                ->scalarNode( 'currency' )->end()
                ->arrayNode( 'pictures' )
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode( 'code' )->end()
                            ->scalarNode( 'file' )->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode( 'files' )
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode( 'code' )->end()
                            ->scalarNode( 'file' )->end()
                        ->end()
                    ->end()
                ->end()
        ;
    }
}
