<?php namespace Vankosoft\CatalogBundle\Controller;

use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;
use Vankosoft\CatalogBundle\Form\ProductAssociationsForm;

trait ProductAssociationsTrait
{
    protected function getProductAssociationsForm( ProductInterface $product )
    {
        $form   = $this->createForm( ProductAssociationsForm::class, $product, [
            'method'    => 'POST',
            'action'    => $this->generateUrl( 'vs_catalog_handle_associations', ['productId' => $product->getId()] ),
        ]);
        
        return $form;
    }
}