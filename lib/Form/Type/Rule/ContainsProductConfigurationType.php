<?php namespace Vankosoft\CatalogBundle\Form\Type\Rule;

use Vankosoft\CatalogBundle\Form\Type\ProductAutocompleteChoiceType;
use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ReversedTransformer;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

final class ContainsProductConfigurationType extends AbstractType
{
    /** @var RepositoryInterface */
    private $productRepository;
    
    public function __construct( RepositoryInterface $productRepository )
    {
        $this->productRepository    = $productRepository;
    }

    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder
            ->add( 'product_code', ProductAutocompleteChoiceType::class, [
                'label'         => 'sylius.form.promotion_action.add_product_configuration.product',
                'constraints'   => [
                    new NotBlank( ['groups' => ['sylius']] ),
                    new Type( ['type' => 'string', 'groups' => ['sylius']] ),
                ],
            ])
        ;

        $builder->get( 'product_code' )->addModelTransformer(
            new ReversedTransformer( new ResourceToIdentifierTransformer( $this->productRepository, 'code' ) ),
        );
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_promotion_rule_contains_product_configuration';
    }
}
