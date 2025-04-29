<?php namespace Vankosoft\CatalogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Vankosoft\UsersSubscriptionsBundle\Model\PayedServiceSubscriptionPeriod;

final class PricingPlanPaidServiceType extends AbstractType
{
    /** @var string */
    private  $paidServicePeriodClass;
    
    public function __construct(
        string $paidServicePeriodClass
    ) {
        $this->paidServicePeriodClass   = $paidServicePeriodClass;
    }
    
    
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'paidServicePeriod', EntityType::class, [
                'label'                 => 'vs_catalog.form.pricing_plan.paid_service_period',
                'translation_domain'    => 'VSCatalogBundle',
                'class'                 => $this->paidServicePeriodClass,
                'choice_label'          => 'title',
                'group_by'              => function ( PayedServiceSubscriptionPeriod $paidServicePeriod ): string {
                    return $paidServicePeriod ? $paidServicePeriod->getPayedService()->getTitle() : 'Undefined Group';
                },
            ])
        ;
    }
}