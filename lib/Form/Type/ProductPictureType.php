<?php namespace Vankosoft\CatalogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

use Vankosoft\CatalogBundle\Component\Product;

class ProductPictureType extends AbstractType
{
    /** @var string */
    private $dataClass;
    
    public function __construct(
        string $dataClass
    ) {
        $this->dataClass    = $dataClass;
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder
        
            ->add( 'code', ChoiceType::class, [
                'label'                 => 'vs_catalog.form.product.picture_code',
                'placeholder'           => 'vs_catalog.form.product.picture_code_placeholder',
                'translation_domain'    => 'VSCatalogBundle',
                'choices'               => \array_flip( Product::PRODUCT_PICTURE_TYPES ),
                'required'              => false,
            ])
            
            ->add( 'picture', FileType::class, [
                'mapped'                => false,
                'required'              => false,
                
                'label'                 => 'vs_application.form.picture',
                'translation_domain'    => 'VSApplicationBundle',
                
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/svg+xml',
                        ],
                        'mimeTypesMessage' => 'vs_application.form.picture_invalid',
                    ])
                ],
            ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass
        ));
    }
    
    public function getName()
    {
        return 'FormFieldsetField';
    }
}
