<?php namespace Vankosoft\CatalogBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class VSCatalogExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    use PrependDoctrineMigrationsTrait;
    
    /**
     * {@inheritDoc}
     */
    public function load( array $configs, ContainerBuilder $container ): void
    {
        $config = $this->processConfiguration( $this->getConfiguration( [], $container ), $configs );
        
        $loader = new Loader\YamlFileLoader( $container, new FileLocator( __DIR__.'/../Resources/config' ) );
        $loader->load( 'services.yaml' );
        
        // Register resources
        $this->registerResources( 'vs_catalog', $config['orm_driver'], $config['resources'], $container );
        
        // Set Parameters
        $container->setParameter( 'vs_catalog.latest_products_limit', $config['latest_products_limit'] );
        
        $this->prepend( $container );
    }
    
    public function prepend( ContainerBuilder $container ): void
    {
        $config = $container->getExtensionConfig( $this->getAlias() );
        $config = $this->processConfiguration( $this->getConfiguration( [], $container ), $config );
        
        $this->prependDoctrineMigrations( $container );
    }
}
