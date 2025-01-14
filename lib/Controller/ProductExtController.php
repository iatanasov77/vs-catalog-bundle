<?php namespace Vankosoft\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormTypeInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Vankosoft\CatalogBundle\Form\ProductForm;

class ProductExtController extends AbstractController
{
    use ProductAssociationsTrait;
    
    /** @var ManagerRegistry */
    protected $doctrine;
    
    /** @var RepositoryInterface */
    protected $productRepository;
    
    /** @var RepositoryInterface */
    protected $productCategoryRepository;
    
    /** @var RepositoryInterface */
    protected $taxonomyRepository;
    
    /** @var RepositoryInterface */
    protected $tagsWhitelistContextRepository;
    
    /** @var FormTypeInterface */
    protected $productForm;
    
    public function __construct(
        ManagerRegistry $doctrine,
        RepositoryInterface $productRepository,
        RepositoryInterface $productCategoryRepository,
        RepositoryInterface $taxonomyRepository,
        RepositoryInterface $tagsWhitelistContextRepository,
        FormTypeInterface $productForm
    ) {
        $this->doctrine                         = $doctrine;
        $this->productRepository                = $productRepository;
        $this->productCategoryRepository        = $productCategoryRepository;
        $this->taxonomyRepository               = $taxonomyRepository;
        $this->tagsWhitelistContextRepository   = $tagsWhitelistContextRepository;
        $this->productForm                      = $productForm;
    }
    
    public function getForm( $itemId, $locale, Request $request ): Response
    {
        $em     = $this->doctrine->getManager();
        $item   = $this->productRepository->find( $itemId );
        
        if ( $locale != $request->getLocale() ) {
            $item->setTranslatableLocale( $locale );
            $em->refresh( $item );
        }
        
        $taxonomy   = $this->taxonomyRepository->findByCode(
            $this->getParameter( 'vs_catalog.product_category.taxonomy_code' )
        );
        
        $tagsContext    = $this->tagsWhitelistContextRepository->findByTaxonCode( 'catalog-products' );
        
        return $this->render( '@VSCatalog/Pages/Products/partial/product_form.html.twig', [
            'item'          => $item,
            //'form'          => $this->createForm( ProductForm::class, $item )->createView(),
            'form'          => $this->productForm->createView(),
            'taxonomyId'    => $taxonomy->getId(),
            'productTags'   => [], // $tagsContext->getTagsArray(),
        ]);
    }
    
    public function handleAssociationsForm( $productId, Request $request ): Response
    {
        $product    = $this->productRepository->find( $productId );
        if ( ! $product ) {
            throw new \RuntimeException( 'Error Handling Associations Form !!!' );
        }
        
        $form   = $this->getProductAssociationsForm( $product );
        $form->handleRequest( $request );
        if( $form->isSubmitted() ) {
            $product    = $form->getData();
            
            $em         = $this->doctrine->getManager();
            $em->persist( $product );
            $em->flush();
            
            return $this->redirectToRoute( 'vs_catalog_product_index' );
        }
        
        throw new \RuntimeException( 'Associations Form Not Submted Properly !!!' );
    }
    
    public function getCategories( $id, Request $request ): Response
    {
        $selectedValues = $id ? $this->productRepository->find( $id )->getCategories() : null;
        
        $data           = [];
        $this->buildEasyuiCombotreeData(
            $this->productCategoryRepository->findAll(),
            $data,
            $selectedValues ? $selectedValues->getKeys() : [],
            []
        );
        
        return new JsonResponse( $data );
    }
    
    protected function buildEasyuiCombotreeData( $tree, &$data, array $selectedValues, array $leafs )
    {
        $key    = 0;
        foreach( $tree as $node ) {
            $data[$key]   = [
                'id'        => $node->getId(),
                'text'      => $node->getName(),
                'children'  => []
            ];
            if ( \in_array( $node->getId(), $selectedValues ) ) {
                $data[$key]['checked'] = true;
            }
            
            if ( \array_key_exists( $node->getId(), $leafs ) ) {
                $this->buildEasyuiCombotreeData( $leafs[$node->getId()], $data[$key]['children'], $selectedValues, $leafs );
            }
            
            $key++;
        }
    }
}