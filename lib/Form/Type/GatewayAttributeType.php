<?php namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GatewayAttributeType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'name', ChoiceType::class, [
                'required'              => false,
                'choices'               => [
                    'Icon' => ProjectAttribute::ATTRIBUTE_ICON,
                ],
                'placeholder'           => 'vankosoft_org.form.project.attribute_placeholder',
                'translation_domain'    => 'VankoSoftOrg',
            ])
            ->add( 'value', TextType::class, [
                'required'              => false,
                'translation_domain'    => 'VankoSoftOrg',
            ])
        ;
    }
}
