<?php namespace Vankosoft\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class CatalogController extends AbstractController
{
    /** @var RepositoryInterface */
    protected $productCategoryRepository;
    
    /** @var RepositoryInterface */
    protected $productRepository;
    
    /** @var int **/
    protected $latestProductsLimit;
    
    public function __construct(
        RepositoryInterface $productCategoryRepository,
        RepositoryInterface $productRepository,
        int $latestProductsLimit
    ) {
        $this->productCategoryRepository    = $productCategoryRepository;
        $this->productRepository            = $productRepository;
        $this->latestProductsLimit          = $latestProductsLimit;
    }
    
    public function latestProductsAction( Request $request ): Response
    {
        $products   = $this->productRepository->findBy( [], ['updatedAt' => 'DESC'], $this->latestProductsLimit );
        
        return $this->render( '@VSCatalog/Pages/Catalog/latest_products.html.twig', [
            'products'  => $products,
        ]);
    }
    
    public function categoryProductsAction( $categorySlug, Request $request ): Response
    {
        $category   = $this->productCategoryRepository->findByTaxonCode( $categorySlug );
        
        return $this->render( '@VSCatalog/Pages/Catalog/category_products.html.twig', [
            'category'  => $category,
        ]);
    }
    
    public function showProductAction( $categorySlug, $productSlug, Request $request ): Response
    {
        $product   = $this->productRepository->findOneBy( ['slug' => $productSlug] );
        
        return $this->render( '@VSCatalog/Pages/Catalog/show_product.html.twig', [
            'product'  => $product,
        ]);
    }
}