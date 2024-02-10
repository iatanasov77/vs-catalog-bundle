<?php namespace Vankosoft\CatalogBundle\DataFixtures\Factory;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\AbstractExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\ExampleFactoryInterface;
use Vankosoft\CmsBundle\Component\Uploader\FileUploaderInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Vankosoft\CatalogBundle\Component\Product;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;

final class ProductsExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /** @var FactoryInterface */
    private $productsFactory;
    
    /** @var OptionsResolver */
    private $optionsResolver;
    
    /** @var FactoryInterface */
    private $productPicturesFactory;
    
    /** @var FactoryInterface */
    private $productFilesFactory;
    
    /** @var RepositoryInterface */
    private $currenciesRepository;
    
    /** @var RepositoryInterface */
    private $categoriesRepository;
    
    /** @var FileLocatorInterface */
    private ?FileLocatorInterface $fileLocator;
    
    /** @var FileUploaderInterface */
    private ?FileUploaderInterface $picturesUploader;
    
    public function __construct(
        FactoryInterface $productsFactory,
        FactoryInterface $productPicturesFactory,
        FactoryInterface $productFilesFactory,
        RepositoryInterface $currenciesRepository,
        RepositoryInterface $categoriesRepository,
        ?FileLocatorInterface $fileLocator = null,
        ?FileUploaderInterface $picturesUploader = null
    ) {
        $this->productsFactory          = $productsFactory;
        
        $this->optionsResolver          = new OptionsResolver();
        $this->configureOptions( $this->optionsResolver );
        
        $this->productPicturesFactory   = $productPicturesFactory;
        $this->productFilesFactory      = $productFilesFactory;
        
        $this->currenciesRepository     = $currenciesRepository;
        $this->categoriesRepository     = $categoriesRepository;
        
        $this->fileLocator              = $fileLocator;
        $this->picturesUploader         = $picturesUploader;
    }
    
    public function create( array $options = [] ): ProductInterface
    {
        $options    = $this->optionsResolver->resolve( $options );
        
        $entity     = $this->productsFactory->createNew();
        
        $currency   = $this->currenciesRepository->findOneBy( ['code' => $options['currency']] );
        $category   = $this->categoriesRepository->findByTaxonCode( $options['category_code'] );
        
        $entity->addCategory( $category );
        $entity->setTranslatableLocale( $options['locale'] );
        $entity->setName( $options['name'] );
        $entity->setDescription( $options['description'] );
        $entity->setPublished( $options['published'] );
        $entity->setPrice( $options['price'] );
        $entity->setCurrency( $currency );
        
        if ( isset( $options['pictures'] ) && null !== $options['pictures'] ) {
            $this->addProductPictures( $entity, $options['pictures'] );
        }
        
        if ( isset( $options['files'] ) && null !== $options['files'] ) {
            $this->addProductFiles( $entity, $options['files'] );
        }
        
        return $entity;
    }
    
    protected function configureOptions( OptionsResolver $resolver ): void
    {
        $resolver
            ->setDefault( 'name', null )
            ->setAllowedTypes( 'name', ['string'] )
            
            ->setDefault( 'description', null )
            ->setAllowedTypes( 'description', ['string'] )
            
            ->setDefault( 'category_code', null )
            ->setAllowedTypes( 'category_code', ['string'] )
            
            ->setDefault( 'locale', null )
            ->setAllowedTypes( 'locale', ['string'] )
            
            ->setDefault( 'published', null )
            ->setAllowedTypes( 'published', ['bool'] )
            
            ->setDefault( 'price', null )
            ->setAllowedTypes( 'price', ['float'] )
            
            ->setDefault( 'currency', null )
            ->setAllowedTypes( 'currency', ['string'] )
            
            ->setDefault( 'pictures', null )
            ->setDefault( 'files', null )
        ;
    }
    
    private function addProductPictures( &$entity, array $pictures )
    {
        if ( $this->fileLocator === null || $this->picturesUploader === null ) {
            throw new \RuntimeException( 'You must configure a $fileLocator or/and $picturesUploader' );
        }
        
        foreach( $pictures as $op ) {
            $imagePath      = $this->fileLocator->locate( '@VSCatalogBundle/Resources/fixtures/productPictures/' . $op['file'] );
            $uploadedImage  = new UploadedFile( $imagePath, basename( $imagePath ) );
            
            $picture        = $this->productPicturesFactory->createNew();
            $picture->setFile( $uploadedImage );
            $picture->setOriginalName( $op['file'] );
            
            $this->picturesUploader->upload( $picture );
            $picture->setFile( null );
            
            if ( $op['code'] == Product::PRODUCT_PICTURE_TYPE_OTHER ) {
                $picture->setCode( $op['code'] . '-' . \microtime() );
            } else {
                $picture->setCode( $op['code'] );
            }
            
            $entity->addPicture( $picture );
        }
    }
    
    private function addProductFiles( &$entity, array $files )
    {
        if ( $this->fileLocator === null || $this->picturesUploader === null ) {
            throw new \RuntimeException( 'You must configure a $fileLocator or/and $picturesUploader' );
        }
        
        foreach( $files as $op ) {
            $imagePath      = $this->fileLocator->locate( '@VSCatalogBundle/Resources/fixtures/productContents/' . $op['file'] );
            $uploadedImage  = new UploadedFile( $imagePath, basename( $imagePath ) );
            
            $file           = $this->productFilesFactory->createNew();
            $file->setFile( $uploadedImage );
            $file->setOriginalName( $op['file'] );
            
            $this->picturesUploader->upload( $file );
            $file->setFile( null );
            
            if ( $op['code'] == Product::PRODUCT_FILE_TYPE_OTHER ) {
                $file->setCode( $op['code'] . '-' . \microtime() );
            } else {
                $file->setCode( $op['code'] );
            }
            
            $entity->addFile( $file );
        }
    }
}
