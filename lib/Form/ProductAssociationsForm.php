<?php namespace Vankosoft\CatalogBundle\Form;

use Vankosoft\ApplicationBundle\Form\AbstractForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductAssociationsForm extends AbstractForm
{
    public function __construct(
        string $dataClass
    ) {
        parent::__construct( $dataClass );
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        parent::buildForm( $builder, $options );
        
        $builder
            ->add( 'associations', Type\ProductAssociationsType::class, [
                'label' => false,
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
                'productClass',
            ])
            
            ->setAllowedTypes( 'productClass', 'string' )
        ;
    }
    
    public function getName()
    {
        return 'vs_catalog.product_associations';
    }
}