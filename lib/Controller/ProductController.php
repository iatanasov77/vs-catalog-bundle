<?php namespace Vankosoft\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProductController extends AbstractCrudController
{
    use ProductAssociationsTrait;
    
    protected function customData( Request $request, $entity = null ): array
    {
        $translations   = $this->classInfo['action'] == 'indexAction' ? $this->getTranslations() : [];
        
        $taxonomy   = $this->get( 'vs_application.repository.taxonomy' )->findByCode(
                                    $this->getParameter( 'vs_catalog.product_category.taxonomy_code' )
                                );
        
        $selectedTaxonIds   = [];
        $associationsForm   = null;
        if ( $this->classInfo['action'] == 'updateAction' ) {
            foreach ( $entity->getCategories() as $cat ) {
                $selectedTaxonIds[] = $cat->getTaxon()->getId();
            }
            $associationsForm   = $this->getProductAssociationsForm( $entity );
        }
        
        $tagsContext    = $this->get( 'vs_application.repository.tags_whitelist_context' )->findByTaxonCode( 'catalog-products' );
        
        return [
            'categories'        => $this->get( 'vs_catalog.repository.product_category' )->findAll(),
            'taxonomyId'        => $taxonomy ? $taxonomy->getId() : 0,
            'translations'      => $translations,
            'productTags'       => $tagsContext->getTagsArray(),
            'selectedTaxonIds'  => $selectedTaxonIds,
            'associationsForm'  => $associationsForm ? $associationsForm->createView() : null,
        ];
    }
    
    protected function prepareEntity( &$entity, &$form, Request $request )
    {
        $categories = new ArrayCollection();
        $pcr        = $this->get( 'vs_catalog.repository.product_category' );
        
        $formLocale = $request->request->get( 'locale' );
        $formPost   = $request->request->all( 'product_form' );
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
            
            foreach ( $entity->getCategories() as $cat ) {
                if ( ! $categories->contains( $cat ) ) {
                    $entity->removeCategory( $cat );
                }
            }
        }
        
        $pictures    = $request->files->get( 'product_form' );
        foreach ( $pictures as $pic ) {
            // echo "<pre>"; var_dump( \reset( $pic )['picture'] ); die;
            $productPictureFile = \reset( $pic )['picture'];
            if ( $productPictureFile ) {
                $this->addProductPicture( $entity, $productPictureFile );
            }
        }
        
        /** WORKAROUND */
        foreach ( $entity->getPictures() as $pic ) {
            if ( empty( $pic->getPath() ) ) {
                $entity->removePicture( $pic );
            }
        }
    }
    
    private function getTranslations()
    {
        $translations   = [];
        $transRepo      = $this->get( 'vs_application.repository.translation' );
        
        foreach ( $this->getRepository()->findAll() as $product ) {
            $translations[$product->getId()] = array_keys( $transRepo->findTranslations( $product ) );
        }
        
        return $translations;
    }
    
    private function addProductPicture( &$entity, File $file ): void
    {
        $uploadedFile   = new UploadedFile( $file->getRealPath(), $file->getBasename() );
        $productPicture = $this->get( 'vs_catalog.factory.product_picture' )->createNew();
        
        $productPicture->setOriginalName( $file->getClientOriginalName() );
        $productPicture->setFile( $uploadedFile );
        
        $this->get( 'vs_application.app_pictures_uploader' )->upload( $productPicture );
        $productPicture->setFile( null ); // reset File Because: Serialization of 'Symfony\Component\HttpFoundation\File\UploadedFile' is not allowed
        
        $entity->addPicture( $productPicture );
    }
}
