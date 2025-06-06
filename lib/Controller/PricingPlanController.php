<?php namespace Vankosoft\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PricingPlanController extends AbstractCrudController
{
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
        
        return [
            'categories'        => $this->get( 'vs_catalog.repository.pricing_plan_category' )->findAll(),
            'taxonomyId'        => $taxonomy ? $taxonomy->getId() : 0,
            'translations'      => $translations,
            'selectedTaxonIds'  => $selectedTaxonIds,
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
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
    
    private function getTranslations()
    {
        $translations   = [];
        $transRepo      = $this->get( 'vs_application.repository.translation' );
        
        foreach ( $this->getRepository()->findAll() as $pricingPlan ) {
            $translations[$pricingPlan->getId()] = array_keys( $transRepo->findTranslations( $pricingPlan ) );
        }
        
        return $translations;
    }
}
