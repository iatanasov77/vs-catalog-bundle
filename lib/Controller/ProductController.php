<?php namespace Vankosoft\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Vankosoft\ApplicationBundle\Controller\AbstractCrudController;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use Vankosoft\ApplicationBundle\Controller\Traits\FilterFormTrait;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductPictureInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductFileInterface;
use Vankosoft\CatalogBundle\Component\Product;

class ProductController extends AbstractCrudController
{
    use FilterFormTrait;
    use ProductAssociationsTrait;
    
    protected function customData( Request $request, $entity = null ): array
    {
        $translations   = $this->classInfo['action'] == 'indexAction' ? $this->getTranslations( false ) : [];
        
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
        
        $categoryClass  = $this->getParameter( 'vs_catalog.model.product_category.class' );
        $filterCategory = $request->attributes->get( 'filterCategory' );
        $filterForm     = $this->getFilterForm( $categoryClass, $filterCategory, $request );
        
        return [
            'items'             => $this->getRepository()->findAll(),
            'categories'        => $this->get( 'vs_catalog.repository.product_category' )->findAll(),
            'taxonomyId'        => $taxonomy ? $taxonomy->getId() : 0,
            'translations'      => $translations,
            'productTags'       => $tagsContext->getTagsArray(),
            'selectedTaxonIds'  => $selectedTaxonIds,
            'associationsForm'  => $associationsForm ? $associationsForm->createView() : null,
            'filterForm'        => $filterForm->createView(),
            'filterCategory'    => $filterCategory,
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
        
        $formFiles  = $request->files->get( 'product_form' );
        
        $pictures   = $form['pictures']->getData();
        if ( ! empty( $formFiles['pictures'] ) ) {
            foreach ( $formFiles['pictures'] as $pictureId => $picture ) {
                if ( ! $picture['picture'] ) {
                    continue;
                }
                
                $this->addProductPicture( $entity, $pictures[$pictureId], $picture['picture'], $formPost['pictures'][$pictureId]["code"] );
            }
        }
        
        $files      = $form['files']->getData();
        if ( ! empty( $formFiles['files'] ) ) {
            foreach ( $formFiles['files'] as $fileId => $file ) {
                if ( ! $file['file'] ) {
                    continue;
                }
                
                $this->addProductFile( $entity, $files[$fileId], $file['file'], $formPost['files'][$fileId]["code"] );
            }
        }
        
        /** WORKAROUND */
        foreach ( $entity->getPictures() as $pic ) {
            if ( empty( $pic->getPath() ) ) {
                $entity->removePicture( $pic );
            }
        }
    }
    
    protected function getFilterRepository()
    {
        return $this->get( 'vs_catalog.repository.product_category' );
    }
    
    protected function getTranslations()
    {
        $translations   = [];
        $transRepo      = $this->get( 'vs_application.repository.translation' );
        
        foreach ( $this->getRepository()->findAll() as $product ) {
            $translations[$product->getId()] = array_keys( $transRepo->findTranslations( $product ) );
        }
        
        return $translations;
    }
    
    protected function addProductPicture( ProductInterface &$entity, ProductPictureInterface &$productPicture, File $file, string $code ): void
    {
        $productPicture->setOriginalName( $file->getClientOriginalName() );
        
        $uploadedFile   = new UploadedFile( $file->getRealPath(), $file->getBasename() );
        $productPicture->setFile( $uploadedFile );
        
        $this->get( 'vs_application.app_pictures_uploader' )->upload( $productPicture );
        $productPicture->setFile( null ); // reset File Because: Serialization of 'Symfony\Component\HttpFoundation\File\UploadedFile' is not allowed
        
        if ( $code == Product::PRODUCT_PICTURE_TYPE_OTHER ) {
            $productPicture->setCode( $code . '-' . \microtime() );
        } else {
            $productPicture->setCode( $code );
        }
        
        
        $entity->addPicture( $productPicture );
    }
    
    protected function addProductFile( ProductInterface &$entity, ProductFileInterface &$productFile, File $file, string $code ): void
    {
        $productFile->setOriginalName( $file->getClientOriginalName() );
        
        $uploadedFile   = new UploadedFile( $file->getRealPath(), $file->getBasename() );
        $productFile->setFile( $uploadedFile );
        
        $this->get( 'vs_application.app_pictures_uploader' )->upload( $productFile );
        $productFile->setFile( null ); // reset File Because: Serialization of 'Symfony\Component\HttpFoundation\File\UploadedFile' is not allowed
        
        if ( $code == Product::PRODUCT_FILE_TYPE_OTHER ) {
            $productFile->setCode( $code . '-' . \microtime() );
        } else {
            $productFile->setCode( $code );
        }
        
        
        $entity->addFile( $productFile );
    }
}
