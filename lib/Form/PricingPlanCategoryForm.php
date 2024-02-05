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

use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanCategoryInterface;

class PricingPlanCategoryForm extends AbstractForm
{
    /** @var string */
    protected $categoryClass;
    
    /** @var RepositoryInterface */
    protected $repository;
    
    public function __construct(
        string $dataClass,
        RequestStack $requestStack,
        RepositoryInterface $localesRepository,
        RepositoryInterface $repository
    ) {
        parent::__construct( $dataClass );
        
        $this->requestStack         = $requestStack;
        $this->localesRepository    = $localesRepository;
        
        $this->categoryClass        = $dataClass;
        $this->repository           = $repository;
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
            
            ->add( 'description', CKEditorType::class, [
                'label'                 => 'vs_payment.form.description',
                'translation_domain'    => 'VSPaymentBundle',
                'required'              => false,
                'mapped'                => false,
                'config'                => [
                    'uiColor'               => $options['ckeditor_uiColor'],
                    'extraAllowedContent'   => $options['ckeditor_extraAllowedContent'],
                    
                    'toolbar'               => $options['ckeditor_toolbar'],
                    'extraPlugins'          => array_map( 'trim', explode( ',', $options['ckeditor_extraPlugins'] ) ),
                    'removeButtons'         => $options['ckeditor_removeButtons'],
                ],
            ])
            
            ->add( 'parent', EntityType::class, [
                'label'                 => 'vs_payment.form.parent_category',
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
                'placeholder'   => 'vs_payment.form.parent_category_placeholder',
            ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
        
        $resolver
            ->setDefaults([
                'csrf_protection'   => false,
                
                // CKEditor Options
                'ckeditor_uiColor'              => '#ffffff',
                'ckeditor_extraAllowedContent'  => '*[*]{*}(*)',
                
                'ckeditor_toolbar'              => 'full',
                'ckeditor_extraPlugins'         => '',
                'ckeditor_removeButtons'        => '',
            ])
            
            ->setDefined([
                'pricing_plan_category',
                
                // CKEditor Options
                'ckeditor_uiColor',
                'ckeditor_extraAllowedContent',
                'ckeditor_toolbar',
                'ckeditor_extraPlugins',
                'ckeditor_removeButtons',
            ])
            
            ->setAllowedTypes( 'pricing_plan_category', PricingPlanCategoryInterface::class )
            
            // CKEditor Options
            ->setAllowedTypes( 'ckeditor_uiColor', 'string' )
            ->setAllowedTypes( 'ckeditor_extraAllowedContent', 'string' )
            ->setAllowedTypes( 'ckeditor_toolbar', 'string' )
            ->setAllowedTypes( 'ckeditor_extraPlugins', 'string' )
            ->setAllowedTypes( 'ckeditor_removeButtons', 'string' )
        ;
    }
    
    public function getName()
    {
        return 'vs_catalog.pricing_plan_category';
    }
}