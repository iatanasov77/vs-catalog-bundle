<?php namespace Vankosoft\CatalogBundle\Form;

use Vankosoft\ApplicationBundle\Form\AbstractForm;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Repository\RepositoryInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use daddl3\SymfonyCKEditor5WebpackViteBundle\Form\Ckeditor5TextareaType;

use Vankosoft\CatalogBundle\Model\Interfaces\ProductCategoryInterface;
use Vankosoft\CmsBundle\Form\Traits\FosCKEditor4Config;

class ProductCategoryForm extends AbstractForm
{
    use FosCKEditor4Config;
    
    /** @var string */
    protected $categoryClass;
    
    /** @var RepositoryInterface */
    protected $repository;
    
    /**
     * Which CkEditor Version to Use
     * ------------------------
     * CkEditor 4 provided by FOSCKEditorBundle OR
     * CkEditor 5 provided by 
     * 
     * @var string
     */
    protected $useCkEditor;
    
    public function __construct(
        string $dataClass,
        RequestStack $requestStack,
        RepositoryInterface $localesRepository,
        RepositoryInterface $repository,
        string $useCkEditor
    ) {
        parent::__construct( $dataClass );
        
        $this->requestStack         = $requestStack;
        $this->localesRepository    = $localesRepository;
        
        $this->categoryClass        = $dataClass;
        $this->repository           = $repository;
        
        $this->useCkEditor          = $useCkEditor;
        
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        parent::buildForm( $builder, $options );
        
        $category   = $options['data'];
        
        $builder
            ->setMethod( $category && $category->getId() ? 'PUT' : 'POST' )
            
            ->add( 'currentLocale', ChoiceType::class, [
                'label'                 => 'vs_cms.form.locale',
                'translation_domain'    => 'VSCmsBundle',
                'choices'               => \array_flip( $this->fillLocaleChoices() ),
                'data'                  => $this->requestStack->getCurrentRequest()->getLocale(),
                'mapped'                => false,
            ])
        
            ->add( 'name', TextType::class, [
                'label'                 => 'vs_payment.form.name',
                'translation_domain'    => 'VSPaymentBundle',
                'mapped'                => false,
            ])
            
            ->add( 'parent', EntityType::class, [
                'label'                 => 'vs_payment.form.parent_category',
                'placeholder'           => 'vs_payment.form.parent_category_placeholder',
                'translation_domain'    => 'VSPaymentBundle',
                'class'                 => $this->categoryClass,
                'query_builder'         => function ( RepositoryInterface $er ) use ( $category )
                {
                    $qb = $er->createQueryBuilder( 'pc' );
                    if  ( $category && $category->getId() ) {
                        $qb->where( 'pc.id != :id' )->setParameter( 'id', $category->getId() );
                    }
                    
                    return $qb; 
                },
                'choice_label'  => 'name',
                'required'      => false,
                'mapped'        => false,
            ])
        ;
            
        if ( $this->useCkEditor == '5' ) {
            $builder->add( 'description', Ckeditor5TextareaType::class, [
                'label'                 => 'vs_payment.form.description',
                'translation_domain'    => 'VSPaymentBundle',
                'required'              => false,
                'mapped'                => false,
                
                'attr' => [
                    'data-ckeditor5-config' => 'devpage'
                ],
            ]);
        } else {
            $builder->add( 'description', CKEditorType::class, [
                'label'                 => 'vs_payment.form.description',
                'translation_domain'    => 'VSPaymentBundle',
                'required'              => false,
                'mapped'                => false,
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
                'validation_groups' => false,
            ])
            
            ->setDefined([
                'product_category',
            ])
            
            ->setAllowedTypes( 'product_category', ProductCategoryInterface::class )
        ;
            
        $this->onfigureCkEditorOptions( $resolver );
    }
    
    public function getName()
    {
        return 'vs_catalog.product_category';
    }
}
