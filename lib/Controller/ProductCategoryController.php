<?php namespace Vankosoft\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;
use Vankosoft\ApplicationBundle\Controller\Traits\TaxonomyHelperTrait;

class ProductCategoryController extends AbstractCrudController
{
    use TaxonomyHelperTrait;
    
    protected function customData( Request $request, $entity = null ): array
    {
        $taxonomy       = $this->getTaxonomy( 'vs_catalog.product_category.taxonomy_code' );
        
        $translations   = $this->classInfo['action'] == 'indexAction' ? $this->getTranslations( false ) : [];
        if ( $entity && $entity->getTaxon() ) {
            $entity->getTaxon()->setCurrentLocale( $request->getLocale() );
        }
        
        return [
            'taxonomyId'    => $taxonomy ? $taxonomy->getId() : 0,
            'translations'  => $translations,
            'items'         => $this->getRepository()->findAll(),
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $translatableLocale     = $form['currentLocale']->getData();
        $this->get( 'vs_application.slug_generator' )->setLocaleCode( $translatableLocale );
        
        $categoryName           = $form['name']->getData();
        $categoryDescription    = $form['description']->getData();
        $parentCategory         = isset( $_POST['product_category_form']['parent'] ) ?
                                    $this->get( 'vs_catalog.repository.product_category' )->findByTaxonId( $_POST['product_category_form']['parent'] ) :
                                    null;
        
        if ( $entity->getTaxon() ) {
            $entityTaxon    = $entity->getTaxon();
            
            $entityTaxon->getTranslation( $translatableLocale );
            $entityTaxon->setCurrentLocale( $translatableLocale );
            $request->setLocale( $translatableLocale );
            if ( ! in_array( $translatableLocale, $entityTaxon->getExistingTranslations() ) ) {
                $taxonTranslation   = $this->createTranslation( $entityTaxon, $translatableLocale, $categoryName, $categoryDescription );
                
                $entityTaxon->addTranslation( $taxonTranslation );
            } else {
                $taxonTranslation   = $entityTaxon->getTranslation( $translatableLocale );

                $taxonTranslation->setName( $categoryName );
                $taxonTranslation->setDescription( $categoryDescription );
                $taxonTranslation->setSlug( $this->get( 'vs_application.slug_generator' )->generate( $categoryName ) );
            }
            
            if ( $parentCategory ) {
                $entityTaxon->setParent( $parentCategory->getTaxon() );
            }
            
            $entity->setParent( $parentCategory );
        } else {
            /*
             * @WORKAROUND Create Taxon If not exists
             */
            $taxonomy   = $this->get( 'vs_application.repository.taxonomy' )->findByCode(
                                        $this->getParameter( 'vs_catalog.product_category.taxonomy_code' )
                                    );
            $newTaxon   = $this->createTaxon(
                $categoryName,
                $translatableLocale,
                $parentCategory ? $parentCategory->getTaxon() : null,
                $taxonomy->getId()
            );
            $newTaxon->setDescription( $categoryDescription );
            
            $entity->setTaxon( $newTaxon );
            $entity->setParent( $parentCategory );
        }
    }
}
