<?php namespace Vankosoft\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class ProductExtController extends AbstractController
{
    /** @var RepositoryInterface */
    protected $productRepository;
    
    /** @var RepositoryInterface */
    protected $productCategoryRepository;
    
    public function __construct(
        RepositoryInterface $productRepository,
        RepositoryInterface $productCategoryRepository
    ) {
        $this->productRepository            = $productRepository;
        $this->productCategoryRepository    = $productCategoryRepository;
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