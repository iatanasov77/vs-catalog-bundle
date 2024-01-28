<?php namespace Vankosoft\CatalogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ProductAssociationType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'paidService', EntityType::class, [
                'class'                 => $this->paidServicePeriodClass,
                'choice_label'          => 'title',
                'group_by'              => function ( PayedServiceSubscriptionPeriod $paidServicePeriod ): string {
                    return $paidServicePeriod ? $paidServicePeriod->getPayedService()->getTitle() : 'Undefined Group';
                },
                'label'                 => 'vs_payment.form.pricing_plan.paid_service',
                'placeholder'           => 'vs_payment.form.pricing_plan.paid_service_placeholder',
                'translation_domain'    => 'VSPaymentBundle',
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