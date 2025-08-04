<?php namespace Vankosoft\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Vankosoft\ApplicationBundle\Component\Status;

class PricingPlanExtController extends AbstractController
{
    /** @var ManagerRegistry */
    protected $doctrine;
    
    /** @var RepositoryInterface */
    protected $pricingPlansRepository;
    
    /** @var RepositoryInterface */
    protected $paidServicesRepository;
    
    public function __construct(
        ManagerRegistry $doctrine,
        RepositoryInterface $pricingPlanRepository,
        RepositoryInterface $payedServiceRepository
    ) {
        $this->doctrine                 = $doctrine;
        $this->pricingPlansRepository   = $pricingPlanRepository;
        $this->paidServicesRepository   = $payedServiceRepository;
    }
    
    public function getPaidServicesJson( $id, Request $request ): Response
    {
        $selectedValues = $this->pricingPlansRepository->find( $id )->getPaidServices();
        
        $data           = [];
        $this->buildEasyuiCombotreeData(
            $this->paidServicesRepository->findAll(),
            $data,
            $selectedValues->getKeys(),
            [],
            false
        );
        
        return new JsonResponse( $data );
    }
    
    public function sortAction( $id, $position, Request $request ): Response
    {
        $em             = $this->doctrine->getManager();
        $pricingPlan    = $this->pricingPlansRepository->find( $id );
        
        $pricingPlan->setPosition( $position );
        $em->persist( $pricingPlan );
        $em->flush();
        
        return new JsonResponse([
            'status'   => Status::STATUS_OK
        ]);
    }
    
    protected function buildEasyuiCombotreeData( $tree, &$data, array $selectedValues, array $leafs, $notLeafs )
    {
        $key    = 0;
        foreach( $tree as $node ) {
            $data[$key]   = [
                'id'        => $node->getId(),
                'text'      => $notLeafs ? $node->getTitle() . ' ' . $node->getPrice() . ' ' . $node->getCurrencyCode() : $node->getTitle(),
                'children'  => [],
                'disabled'  => ! $notLeafs
            ];
            if ( \in_array( $node->getId(), $selectedValues ) ) {
                $data[$key]['checked'] = true;
            }
            
            if ( \array_key_exists( $node->getId(), $leafs ) ) {
                $this->buildEasyuiCombotreeData( $leafs[$node->getId()], $data[$key]['children'], $selectedValues, $leafs, false );
            }
            
            // Buld Child Categories After Leafs because Leafs override children keys
            if ( ! $notLeafs && $node->getSubscriptionPeriods()->count() ) {
                $this->buildEasyuiCombotreeData( $node->getSubscriptionPeriods(), $data[$key]['children'], $selectedValues, $leafs, true );
            }
            
            $key++;
        }
    }
}