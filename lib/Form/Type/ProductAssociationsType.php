<?php namespace Vankosoft\CatalogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Bundle\ResourceBundle\Form\Type\FixedCollectionType;
use Sylius\Component\Resource\Repository\RepositoryInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Vankosoft\CatalogBundle\Model\Interfaces\AssociationTypeInterface;
use Vankosoft\CatalogBundle\Repository\ProductCategoryRepository;

final class ProductAssociationsType extends AbstractType
{
    /** @var RepositoryInterface */
    private $productAssociationTypeRepository;
    
    /** @var DataTransformerInterface */
    private $productsToProductAssociationsTransformer;
    
    /** @var ProductCategoryRepository */
    private $productCategoryRepository;
    
    /** @var string */
    private $productClass;
    
    public function __construct(
        RepositoryInterface $productAssociationTypeRepository,
        DataTransformerInterface $productsToProductAssociationsTransformer,
        ProductCategoryRepository $productCategoryRepository,
        string $productClass
    ) {
        $this->productAssociationTypeRepository         = $productAssociationTypeRepository;
        $this->productsToProductAssociationsTransformer = $productsToProductAssociationsTransformer;
        $this->productCategoryRepository                = $productCategoryRepository;
        $this->productClass                             = $productClass;
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder->addModelTransformer( $this->productsToProductAssociationsTransformer );
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        $resolver->setDefaults([
            'entries'           => $this->productAssociationTypeRepository->findAll(),
            
            //'entry_type'    => TextType::class,
            //'entry_type'    => EntityType::class,
            'entry_type'        => ChoiceType::class,
            
            'entry_name'        => fn ( AssociationTypeInterface $productAssociationType ) => $productAssociationType->getCode(),
            'entry_options'     => fn ( AssociationTypeInterface $productAssociationType ) => [
                'label'         => $productAssociationType->getName(),
                
                //'class'     => $this->productClass,
                'multiple'      => true,
                'choices'       => $this->getOptGropupForEntities(),
                
                'attr'          => ['class' => 'form-control product-associations'],
                'label_attr'    => [
                    'class' => 'form-label'
                ],
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
    
    public function getOptGropupForEntities()
    {
        $categories    = $this->productCategoryRepository->findAll();
        $list       = [];
        foreach( $categories as $cat ) {
            $name   = $cat->getName();
            if( count( $cat->getProducts() ) > 0 ) {
                foreach( $cat->getProducts() as $prod ) {
                    //$list[$name][$prod->getId()] = $prod->getName();
                    $list[$name][$prod->getName()] = $prod->getId();
                }
            }
        }
        
        return $list;
    }
}
