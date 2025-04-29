<?php namespace Vankosoft\CatalogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vankosoft\CatalogBundle\Component\Product;

class GatewayAttributeType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder
            ->add( 'name', ChoiceType::class, [
                'required'              => false,
                'choices'               => \array_flip( Product::PRICING_PLAN_ATTRIBUTE_KEYS ),
                'placeholder'           => 'vs_catalog.form.pricing_plan.gateway_attribute_key_placeholder',
                'translation_domain'    => 'VSCatalogBundle',
            ])
            ->add( 'value', TextType::class, [
                'attr' => [
                    'placeholder' => 'vs_catalog.form.pricing_plan.gateway_attribute_value_placeholder'
                ],
                'required'              => false,
                'translation_domain'    => 'VSCatalogBundle',
            ])
        ;
    }
}
