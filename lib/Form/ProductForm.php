<?php namespace Vankosoft\CatalogBundle\Form;

use Vankosoft\ApplicationBundle\Form\AbstractForm;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Repository\RepositoryInterface;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use daddl3\SymfonyCKEditor5WebpackViteBundle\Form\Ckeditor5TextareaType;

use Vankosoft\PaymentBundle\Model\Product;
use Vankosoft\PaymentBundle\Model\Interfaces\ProductInterface;
use Vankosoft\CmsBundle\Form\Traits\FosCKEditor4Config;

class ProductForm extends AbstractForm
{
    use FosCKEditor4Config;
    
    /** @var string */
    protected $categoryClass;
    
    /** @var string */
    protected $currencyClass;
    
    /**
     * Which CkEditor Version to Use
     * ------------------------
     * CkEditor 4 provided by FOSCKEditorBundle OR
     * CkEditor 5 provided by
     *
     * @var string
     */
    protected $useCkEditor;
    
    /** @var string */
    protected $ckeditor5Editor;
    
    public function __construct(
        string $dataClass,
        RequestStack $requestStack,
        RepositoryInterface $localesRepository,
        string $categoryClass,
        string $currencyClass,
        
        string $useCkEditor,
        string $ckeditor5Editor
    ) {
        parent::__construct( $dataClass );
        
        $this->requestStack         = $requestStack;
        $this->localesRepository    = $localesRepository;
        
        $this->categoryClass        = $categoryClass;
        $this->currencyClass        = $currencyClass;
        
        $this->useCkEditor          = $useCkEditor;
        $this->ckeditor5Editor      = $ckeditor5Editor;
    }

    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        parent::buildForm( $builder, $options );
        
        $entity         = $builder->getData();
        $currentLocale  = $entity->getTranslatableLocale() ?: $this->requestStack->getCurrentRequest()->getLocale();
        
        $builder
            ->add( 'locale', ChoiceType::class, [
                'label'                 => 'vs_cms.form.locale',
                'translation_domain'    => 'VSCmsBundle',
                'choices'               => \array_flip( $this->fillLocaleChoices() ),
                'data'                  => $currentLocale,
                'mapped'                => false,
            ])
            
            ->add( 'productCategories', HiddenType::class, [
                'mapped'    => false,
                'data'      => \json_encode( $entity->getCategories()->getKeys() )
            ])
            
            ->add( 'enabled', CheckboxType::class, [
                'label'                 => 'vs_payment.form.active',
                'translation_domain'    => 'VSPaymentBundle',
            ])  
            
            ->add( 'categories', EntityType::class, [
                'label'                 => 'vs_payment.form.categories',
                'translation_domain'    => 'VSPaymentBundle',
                'multiple'              => true,
                'required'              => true,
                'placeholder'           => 'vs_payment.form.categories_placeholder',
                'class'                 => $this->categoryClass,
                'choice_label'          => 'name',
            ])
            
            ->add( 'category_taxon', ChoiceType::class, [
                'label'                 => 'vs_payment.form.categories',
                'translation_domain'    => 'VSPaymentBundle',
                'multiple'              => true,
                'required'              => false,   // Is Required but Used EasyUi
                'mapped'                => false,
                'placeholder'           => 'vs_payment.form.categories_placeholder',
            ])
            
            ->add( 'name', TextType::class, [
                'label'                 => 'vs_payment.form.name',
                'translation_domain'    => 'VSPaymentBundle',
            ])
            
            ->add( 'inStock', NumberType::class, [
                'label'                 => 'vs_catalog.form.in_stock',
                'translation_domain'    => 'VSCatalogBundle',
                'html5'                 => true,
                'attr'                  => [
                    'min' => -1,
                ],
            ])
            
            ->add( 'pictures', CollectionType::class, [
                'entry_type'   => Type\ProductPictureType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false
            ])
            
            ->add( 'files', CollectionType::class, [
                'entry_type'   => Type\ProductFileType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false
            ])
            
            ->add( 'price', NumberType::class, [
                'label'                 => 'vs_payment.form.price',
                'required'              => true,
                'scale'                 => 2,
                'rounding_mode'         => $options['rounding_mode'],
                'translation_domain'    => 'VSPaymentBundle',
            ])
            
            ->add( 'currency', EntityType::class, [
                'label'                 => 'vs_payment.form.currency_label',
                'required'              => true,
                'class'                 => $this->currencyClass,
                'choice_label'          => 'code',
                'placeholder'           => 'vs_payment.form.currency_placeholder',
                'translation_domain'    => 'VSPaymentBundle',
            ])
            
            ->add( 'tagsInputWhitelist', HiddenType::class, ['mapped' => false, 'required' => false] )
            ->add( 'tags', TextType::class, [
                'label'                 => 'vs_application.form.tags',
                'translation_domain'    => 'VSApplicationBundle',
                'required'              => false,
            ])
        ;
            
        if ( $this->useCkEditor == '5' ) {
            $builder->add( 'description', Ckeditor5TextareaType::class, [
                'label'                 => 'vs_payment.form.description',
                'translation_domain'    => 'VSPaymentBundle',
                'required'              => false,
                
                'attr' => [
                    'data-ckeditor5-config' => $this->ckeditor5Editor
                ],
            ]);
        } else {
            $builder->add( 'description', CKEditorType::class, [
                'label'                 => 'vs_payment.form.description',
                'translation_domain'    => 'VSPaymentBundle',
                'required'              => false,
                'config'                => $this->ckEditorConfig( $options ),
            ]);
        }
    }

    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
        
        $resolver
            ->setDefaults([
                'csrf_protection'   => false,
                'rounding_mode'     => \NumberFormatter::ROUND_HALFEVEN,
            ])
            
            ->setDefined([
                'product',
            ])
            
            ->setAllowedTypes( 'product', ProductInterface::class )
        ;
            
        $this->configureCkEditorOptions( $resolver );
    }
    
    public function getName()
    {
        return 'vs_catalog.product';
    }
}

