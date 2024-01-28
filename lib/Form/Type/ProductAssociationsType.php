<?php namespace Vankosoft\CatalogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Bundle\ResourceBundle\Form\Type\FixedCollectionType;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\AssociationTypeInterface;

final class ProductAssociationsType extends AbstractType
{
    /** @var RepositoryInterface */
    private $productAssociationTypeRepository;
    
    /** @var DataTransformerInterface */
    private $productsToProductAssociationsTransformer;
    
    public function __construct(
        RepositoryInterface $productAssociationTypeRepository,
        DataTransformerInterface $productsToProductAssociationsTransformer
    ) {
        $this->productAssociationTypeRepository         = $productAssociationTypeRepository;
        $this->productsToProductAssociationsTransformer = $productsToProductAssociationsTransformer;
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder->addModelTransformer( $this->productsToProductAssociationsTransformer );
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        $resolver->setDefaults([
            'entries'       => $this->productAssociationTypeRepository->findAll(),
            'entry_type'    => TextType::class,
            'entry_name'    => fn ( AssociationTypeInterface $productAssociationType ) => $productAssociationType->getCode(),
            'entry_options' => fn ( AssociationTypeInterface $productAssociationType ) => [
                'label' => $productAssociationType->getName(),
            ],
        ]);
    }
    
    public function getParent(): string
    {
        return FixedCollectionType::class;
    }
    
    public function getBlockPrefix(): string
    {
        return 'vs_catalog_product_associations';
    }
}
