<?php namespace Vankosoft\CatalogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Factory\Factory;

use Vankosoft\CatalogBundle\Model\Product;
use Vankosoft\CatalogBundle\Form\ProductForm;
use Vankosoft\CatalogBundle\Controller\ProductController;
use Vankosoft\CatalogBundle\Model\ProductCategory;
use Vankosoft\CatalogBundle\Repository\ProductCategoryRepository;
use Vankosoft\CatalogBundle\Form\ProductCategoryForm;
use Vankosoft\CatalogBundle\Controller\ProductCategoryController;
use Vankosoft\CatalogBundle\Model\ProductPicture;

use Vankosoft\CatalogBundle\Model\PricingPlanCategory;
use Vankosoft\CatalogBundle\Repository\PricingPlanCategoryRepository;
use Vankosoft\CatalogBundle\Controller\PricingPlanCategoryController;
use Vankosoft\CatalogBundle\Form\PricingPlanCategoryForm;
use Vankosoft\CatalogBundle\Model\PricingPlan;
use Vankosoft\CatalogBundle\Controller\PricingPlanController;
use Vankosoft\CatalogBundle\Form\PricingPlanForm;
use Vankosoft\CatalogBundle\Repository\PricingPlansRepository;

use Vankosoft\CatalogBundle\Model\PricingPlanSubscription;
use Vankosoft\CatalogBundle\Repository\PricingPlansSubscriptionsRepository;
use Vankosoft\CatalogBundle\Controller\PricingPlanSubscriptionsController;

use Vankosoft\CatalogBundle\Model\AssociationType;
use Vankosoft\CatalogBundle\Controller\AssociationTypeController;
use Vankosoft\CatalogBundle\Form\AssociationTypeForm;

use Vankosoft\CatalogBundle\Model\ProductAssociation;
use Vankosoft\CatalogBundle\Model\ServiceAssociation;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder    = new TreeBuilder( 'vs_catalog' );
        $rootNode       = $treeBuilder->getRootNode();
        
        $rootNode
            ->children()
                ->scalarNode( 'orm_driver' )
                    ->defaultValue( SyliusResourceBundle::DRIVER_DOCTRINE_ORM )->cannotBeEmpty()
                ->end()
            ->end()
        ;
        
        $this->addResourcesSection( $rootNode );

        return $treeBuilder;
    }
    
    private function addResourcesSection( ArrayNodeDefinition $node ): void
    {
        $node
            ->children()
                ->arrayNode( 'resources' )
                    ->addDefaultsIfNotSet()
                    ->children()
                        
                        ->arrayNode( 'product' )
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode( 'options' )->end()
                                ->arrayNode( 'classes' )
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode( 'model' )->defaultValue( Product::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'controller' )->defaultValue( ProductController::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'repository' )->defaultValue( EntityRepository::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'factory' )->defaultValue( Factory::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'form' )->defaultValue( ProductForm::class )->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        
                        ->arrayNode( 'product_picture' )
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode( 'options' )->end()
                                ->arrayNode( 'classes' )
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode( 'model' )->defaultValue( ProductPicture::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'repository' )->defaultValue( EntityRepository::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'factory' )->defaultValue( Factory::class )->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        
                        ->arrayNode( 'product_category' )
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode( 'options' )->end()
                                ->arrayNode( 'classes' )
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode( 'model' )->defaultValue( ProductCategory::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'controller' )->defaultValue( ProductCategoryController::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'repository' )->defaultValue( ProductCategoryRepository::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'factory' )->defaultValue( Factory::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'form' )->defaultValue( ProductCategoryForm::class )->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        
                        ->arrayNode( 'pricing_plan_category' )
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode( 'options' )->end()
                                ->arrayNode( 'classes' )
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode( 'model' )->defaultValue( PricingPlanCategory::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'repository' )->defaultValue( PricingPlanCategoryRepository::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'factory' )->defaultValue( Factory::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'controller' )->defaultValue( PricingPlanCategoryController::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'form' )->defaultValue( PricingPlanCategoryForm::class )->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        
                        ->arrayNode( 'pricing_plan' )
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode( 'options' )->end()
                                ->arrayNode( 'classes' )
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode( 'model' )->defaultValue( PricingPlan::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'repository' )->defaultValue( PricingPlansRepository::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'factory' )->defaultValue( Factory::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'controller' )->defaultValue( PricingPlanController::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'form' )->defaultValue( PricingPlanForm::class )->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        
                        ->arrayNode( 'pricing_plan_subscription' )
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode( 'options' )->end()
                                ->arrayNode( 'classes' )
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode( 'model' )->defaultValue( PricingPlanSubscription::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'repository' )->defaultValue( PricingPlansSubscriptionsRepository::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'factory' )->defaultValue( Factory::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'controller' )->defaultValue( PricingPlanSubscriptionsController::class )->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        
                        ->arrayNode( 'association_type' )
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode( 'options' )->end()
                                ->arrayNode( 'classes' )
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode( 'model' )->defaultValue( AssociationType::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'repository' )->defaultValue( EntityRepository::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'factory' )->defaultValue( Factory::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'controller' )->defaultValue( AssociationTypeController::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'form' )->defaultValue( AssociationTypeForm::class )->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        
                        ->arrayNode( 'product_association' )
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode( 'options' )->end()
                                ->arrayNode( 'classes' )
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode( 'model' )->defaultValue( ProductAssociation::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'repository' )->defaultValue( EntityRepository::class )->cannotBeEmpty()->end()
                                        ->scalarNode( 'factory' )->defaultValue( Factory::class )->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        
//                         ->arrayNode( 'service_association' )
//                             ->addDefaultsIfNotSet()
//                             ->children()
//                                 ->variableNode( 'options' )->end()
//                                 ->arrayNode( 'classes' )
//                                     ->addDefaultsIfNotSet()
//                                     ->children()
//                                         ->scalarNode( 'model' )->defaultValue( ServiceAssociation::class )->cannotBeEmpty()->end()
//                                         ->scalarNode( 'repository' )->defaultValue( EntityRepository::class )->cannotBeEmpty()->end()
//                                         ->scalarNode( 'factory' )->defaultValue( Factory::class )->cannotBeEmpty()->end()
//                                     ->end()
//                                 ->end()
//                             ->end()
//                         ->end()
                        
                    ->end()
                ->end()
            ->end()
        ;
    }
}
