<?php namespace Vankosoft\CatalogBundle\Form;

use Vankosoft\ApplicationBundle\Form\AbstractForm;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Resource\Repository\RepositoryInterface;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductAssociationsForm extends AbstractForm
{
    /** @var string */
    protected $categoryClass;
    
    public function __construct(
        string $dataClass,
        string $categoryClass
    ) {
        parent::__construct( $dataClass );
        
        $this->categoryClass        = $categoryClass;
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder
            ->add( 'associations', CollectionType::class, [
                'entry_type'   => Type\ProductAssociationType::class,
                'entry_options' => [
                    //'productClass' => $options['productClass'],
                    'productClass'  => $this->dataClass,
                ],
                
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false
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