<?php namespace Vankosoft\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;

class AssociationTypeController extends AbstractCrudController
{
    protected function customData( Request $request, $entity = null ): array
    {
        $translations   = $this->classInfo['action'] == 'indexAction' ? $this->getTranslations() : [];
        
        return [
            'translations'          => $translations,
            'associationStrategies' => $this->get( 'vs_catalog.association_strategy' )->getStrategies(),
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request ): void
    {
        $formLocale = $request->request->get( 'locale' );
        
        if ( $formLocale ) {
            $entity->setTranslatableLocale( $formLocale );
        }
    }
}
