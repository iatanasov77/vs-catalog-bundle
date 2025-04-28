<?php namespace Vankosoft\CatalogBundle\Form;

use Vankosoft\ApplicationBundle\Form\AbstractForm;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Repository\RepositoryInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use daddl3\SymfonyCKEditor5WebpackViteBundle\Form\Ckeditor5TextareaType;
use App\Form\Type\GatewayAttributeType;

use Vankosoft\UsersSubscriptionsBundle\Model\PayedServiceSubscriptionPeriod;
use Vankosoft\PaymentBundle\Form\Type\CurrencyChoiceType;
use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanInterface;
use Vankosoft\CmsBundle\Form\Traits\FosCKEditor4Config;

class PricingPlanForm extends AbstractForm
{
    use FosCKEditor4Config;
    
    /** @var string */
    protected $categoryClass;
    
    /** @var string */
    protected  $paidServicePeriodClass;
    
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
        string $paidServicePeriodClass,
        
        string $useCkEditor,
        string $ckeditor5Editor
    ) {
        parent::__construct( $dataClass );
        
        $this->requestStack             = $requestStack;
        $this->localesRepository        = $localesRepository;
        
        $this->categoryClass            = $categoryClass;
        $this->paidServicePeriodClass   = $paidServicePeriodClass;
        
        $this->useCkEditor              = $useCkEditor;
        $this->ckeditor5Editor          = $ckeditor5Editor;
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
            
            ->add( 'enabled', CheckboxType::class, [
                'label'                 => 'vs_payment.form.active',
                'translation_domain'    => 'VSPaymentBundle',
            ])
            
            ->add( 'category', EntityType::class, [
                'label'                 => 'vs_payment.form.category',
                'translation_domain'    => 'VSPaymentBundle',
                'required'              => true,
                'placeholder'           => 'vs_payment.form.category_placeholder',
                'class'                 => $this->categoryClass,
                'choice_label'          => 'name',
            ])
            
            ->add( 'category_taxon', ChoiceType::class, [
                'label'                 => 'vs_payment.form.categories',
                'translation_domain'    => 'VSPaymentBundle',
                'multiple'              => false,
                'required'              => false,   // Is Required but Used EasyUi
                'mapped'                => false,
                'placeholder'           => 'vs_payment.form.categories_placeholder',
            ])
            
            ->add( 'title', TextType::class, [
                'label'                 => 'vs_payment.form.title',
                'translation_domain'    => 'VSPaymentBundle',
                'required'              => false,
            ])
            
            ->add( 'premium', CheckboxType::class, [
                'label'                 => 'vs_payment.form.pricing_plan.premium',
                'translation_domain'    => 'VSPaymentBundle',
                'required'              => false,
            ])
            
            ->add( 'discount', NumberType::class, [
                'label'                 => 'vs_payment.form.pricing_plan.discount',
                'translation_domain'    => 'VSPaymentBundle',
                'scale'                 => 2,
                'rounding_mode'         => $options['rounding_mode'],
                'required'              => false,
            ])
            
            ->add( 'price', NumberType::class, [
                'label'                 => 'vs_payment.form.pricing_plan.price',
                'translation_domain'    => 'VSPaymentBundle',
                'scale'                 => 2,
                'rounding_mode'         => $options['rounding_mode'],
                'required'              => true,
            ])
            
            ->add( 'currency', CurrencyChoiceType::class, [
                'label'                 => 'vs_payment.form.pricing_plan.currency',
                'placeholder'           => 'vs_payment.form.pricing_plan.currency_placeholder',
                'translation_domain'    => 'VSPaymentBundle',
                'required'              => true,
            ])
            
            ->add( 'paidService', EntityType::class, [
                'class'                 => $this->paidServicePeriodClass,
                'choice_label'          => 'title',
                'group_by'              => function ( PayedServiceSubscriptionPeriod $paidServicePeriod ): string {
                    return $paidServicePeriod ? $paidServicePeriod->getPayedService()->getTitle() : 'Undefined Group';
                },
                'label'                 => 'vs_payment.form.pricing_plan.paid_service',
                'placeholder'           => 'vs_payment.form.pricing_plan.paid_service_placeholder',
                'translation_domain'    => 'VSPaymentBundle',
                'multiple'              => false,
                'required'              => true,
                'mapped'                => true,
            ])
            
            ->add( 'paymentDescription', TextType::class, [
                'label'                 => 'vs_payment.form.payment_description',
                'translation_domain'    => 'VSPaymentBundle',
                'required'              => false,
            ])
            
            ->add( 'gatewayAttributes', CollectionType::class, [
                'entry_type'   => GatewayAttributeType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false
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
                'pricing_plan',
            ])
            
            ->setAllowedTypes( 'pricing_plan', PricingPlanInterface::class )
        ;
            
        $this->configureCkEditorOptions( $resolver );
    }
    
    public function getName()
    {
        return 'vs_catalog.pricing_plan';
    }
}