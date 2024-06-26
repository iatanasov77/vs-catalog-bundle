<?php namespace Vankosoft\CatalogBundle\DataFixtures\Fixture;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\AbstractResourceFixture;

final class CurrenciesFixture extends AbstractResourceFixture
{
    public function getName(): string
    {
        return 'currencies';
    }
    
    protected function configureResourceNode( ArrayNodeDefinition $resourceNode ): void
    {
        $resourceNode
            ->children()
                ->scalarNode( 'code' )->end()
        ;
    }
}
