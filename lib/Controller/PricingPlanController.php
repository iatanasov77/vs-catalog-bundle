<?php namespace Vankosoft\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sylius\Component\Resource\Repository\RepositoryInterface;

use Vankosoft\ApplicationBundle\Controller\Traits\FilterFormTrait;

class PricingPlanController extends AbstractCrudController
{
    use FilterFormTrait;
    
    protected function customData( Request $request, $entity = null ): array
    {
        $translations   = $this->classInfo['action'] == 'indexAction' ? $this->getTranslations() : [];
        
        $taxonomy   = $this->get( 'vs_application.repository.taxonomy' )->findByCode(
            $this->getParameter( 'vs_catalog.pricing_plan_category.taxonomy_code' )
        );
        
        $selectedTaxonIds   = [];
        if ( $this->classInfo['action'] == 'updateAction' ) {
            $selectedTaxonIds[] = $entity->getCategory()->getTaxon()->getId();
        }
        
        $categoryClass  = $this->getParameter( 'vs_catalog.model.pricing_plan_category.class' );
        $filterCategory = $request->attributes->get( 'filterCategory' );
        $filterForm     = $this->getFilterForm( $categoryClass, $filterCategory, $request );
        
        return [
            'categories'        => $this->get( 'vs_catalog.repository.pricing_plan_category' )->findAll(),
            'taxonomyId'        => $taxonomy ? $taxonomy->getId() : 0,
            'translations'      => $translations,
            'selectedTaxonIds'  => $selectedTaxonIds,
            'filterForm'        => $filterForm->createView(),
            'filterCategory'    => $filterCategory,
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request ): void
    {
        $categories = new ArrayCollection();
        $pcr        = $this->get( 'vs_catalog.repository.pricing_plan_category' );
        $pspr       = $this->get( 'vs_users_subscriptions.repository.payed_service_subscription_period' );
        
        $formLocale = $request->request->get( 'locale' );
        $formPost   = $request->request->all( 'pricing_plan_form' );
        $formTaxon  = isset( $formPost['category_taxon'] ) ? $formPost['category_taxon'] : null;
        
        if ( $formLocale ) {
            $entity->setTranslatableLocale( $formLocale );
        }
        
        if ( $formTaxon ) {
            foreach ( $formTaxon as $taxonId ) {
                $category       = $pcr->findOneBy( ['taxon' => $taxonId] );
                if ( $category ) {
                    $categories[]   = $category;
                    $entity->addCategory( $category );
                }
            }
        }
        
        if ( ! empty( $formPost['paidServicesData'] ) ) {
            foreach ( $formPost['paidServicesData'] as $paidServicePeriodId ) {
                $paidServicePeriod  = $pspr->find( $paidServicePeriodId );
                if ( $paidServicePeriod ) {
                    $entity->addPaidService( $paidServicePeriod );
                }
            }
        }
        
        $gatewayAttributes  = [];
        foreach ( $formPost['gatewayAttributes'] as $gatewayAttribute ) {
            if ( ! empty( $gatewayAttribute['jsonKey'] ) && ! empty( $gatewayAttribute['jsonValue'] ) ) {
                $gatewayAttributes[$gatewayAttribute['jsonKey']] = $gatewayAttribute['jsonValue'];
            }
        }
        
        $entity->setGatewayAttributes( $gatewayAttributes );
    }
    
    protected function getFilterRepository(): ?RepositoryInterface
    {
        return $this->get( 'vs_catalog.repository.pricing_plan_category' );
    }
}
