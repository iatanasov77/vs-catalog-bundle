<?php namespace Vankosoft\CatalogBundle\Form;

use Vankosoft\ApplicationBundle\Form\AbstractForm;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Vankosoft\CatalogBundle\Model\Interfaces\AssociationTypeInterface;
use Vankosoft\CatalogBundle\Component\AssociationStrategy;

class AssociationTypeForm extends AbstractForm
{
    /** @var AssociationStrategy */
    private $associationStrategy;
    
    public function __construct(
        string $dataClass,
        RequestStack $requestStack,
        RepositoryInterface $localesRepository,
        AssociationStrategy $associationStrategy
    ) {
        parent::__construct( $dataClass );
        
        $this->requestStack         = $requestStack;
        $this->localesRepository    = $localesRepository;
        $this->associationStrategy  = $associationStrategy;
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
            
            ->add( 'associationStrategy', ChoiceType::class, [
                'label'                 => 'vs_catalog.form.association_strategy',
                'placeholder'           => 'vs_catalog.form.association_strategy_placeholder',
                'translation_domain'    => 'VSCatalogBundle',
                'choices'               => \array_flip( $this->associationStrategy->getStrategies() ),
            ])
            
            ->add( 'code', TextType::class, [
                'label'                 => 'vs_catalog.form.association_type_code',
                'translation_domain'    => 'VSCatalogBundle',
            ])
            
            ->add( 'name', TextType::class, [
                'label'                 => 'vs_payment.form.name',
                'translation_domain'    => 'VSPaymentBundle',
            ])
        ;
    }

    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
        
        $resolver
            ->setDefaults([
                'csrf_protection'   => false,
            ])
            
            ->setDefined([
                'product',
            ])
            
            ->setAllowedTypes( 'product', AssociationTypeInterface::class )
        ;
    }
    
    public function getName()
    {
        return 'vs_catalog.association_type';
    }
}

