<?php namespace Vankosoft\CatalogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Vankosoft\CatalogBundle\Model\Product;

class ProductAssociationType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'associatedProducts', EntityType::class, [
                'class'                 => $options['productClass'],
                'choice_label'          => 'title',
//                 'group_by'              => function ( Product $product ): string {
//                     return $product ? $product->getCategories()->getName() : 'Undefined Group';
//                 },
                'label'                 => 'vs_catalog.form.product_associations.associated_products',
                'placeholder'           => 'vs_catalog.form.product_associations.associated_products_placeholder',
                'translation_domain'    => 'VSCatalogBundle',
                'multiple'              => true,
                'required'              => false,
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
            
            ->setAllowedTypes( 'productClass', "string" )
        ;
    }
    
    public function getName()
    {
        return 'vs_catalog.product_association_type';
    }
}