<?php namespace Vankosoft\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;

class AssociationTypeController extends AbstractCrudController
{
    protected function customData( Request $request, $entity = null ): array
    {
        $translations   = $this->classInfo['action'] == 'indexAction' ? $this->getTranslations() : [];
        
        return [
            'translations'  => $translations,
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $formLocale = $request->request->get( 'locale' );
        
        if ( $formLocale ) {
            $entity->setTranslatableLocale( $formLocale );
        }
    }
    
    private function getTranslations()
    {
        $translations   = [];
        $transRepo      = $this->get( 'vs_application.repository.translation' );
        
        foreach ( $this->getRepository()->findAll() as $associationType ) {
            $translations[$associationType->getId()] = array_keys( $transRepo->findTranslations( $associationType ) );
        }
        
        return $translations;
    }
}
