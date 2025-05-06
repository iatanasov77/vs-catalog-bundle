<?php namespace Vankosoft\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Component\Resource\Factory\Factory;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Vankosoft\ApplicationBundle\Component\Status;
use Vankosoft\UsersBundle\Security\SecurityBridge;
use Vankosoft\PaymentBundle\Component\OrderFactory;
use Vankosoft\PaymentBundle\Component\Payment\Payment;
use Vankosoft\PaymentBundle\Component\Exception\ShoppingCartException;
use Vankosoft\PaymentBundle\Component\Exception\CheckoutException;
use Vankosoft\PaymentBundle\Model\Interfaces\PayableObjectInterface;
use Vankosoft\CatalogBundle\Form\SelectPricingPlanForm;
use Vankosoft\CatalogBundle\Form\SelectPaymentMethodForm;
use Vankosoft\CatalogBundle\EventSubscriber\Event\CreateSubscriptionEvent;
use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanSubscriptionInterface;

class PricingPlanCheckoutController extends AbstractController
{
    /** @var ManagerRegistry */
    protected $doctrine;
    
    /** @var EventDispatcherInterface */
    protected $eventDispatcher;
    
    /** @var SecurityBridge */
    protected $securityBridge;
    
    /** @var Factory */
    protected $ordersFactory;
    
    /** @var RepositoryInterface */
    protected $ordersRepository;
    
    /** @var Factory */
    protected $orderItemsFactory;
    
    /** @var RepositoryInterface */
    protected $pricingPlanCategoryRepository;
    
    /** @var RepositoryInterface */
    protected $pricingPlansRepository;
    
    /** @var RepositoryInterface */
    protected $paymentMethodsRepository;
    
    /** @var RepositoryInterface */
    protected $subscriptionsRepository;
    
    /** @var Payment */
    protected $vsPayment;
    
    /** @vvar OrderFactory */
    protected $orderFactory;
    
    /** @var RepositoryInterface */
    protected $gatewaysRepository;
    
    public function __construct(
        ManagerRegistry $doctrine,
        EventDispatcherInterface $eventDispatcher,
        SecurityBridge $securityBridge,
        Factory $ordersFactory,
        RepositoryInterface $ordersRepository,
        Factory $orderItemsFactory,
        RepositoryInterface $paymentMethodsRepository,
        Payment $vsPayment,
        OrderFactory $orderFactory,
        RepositoryInterface $gatewaysRepository,
        RepositoryInterface $pricingPlanCategoryRepository,
        RepositoryInterface $pricingPlansRepository,
        RepositoryInterface $subscriptionsRepository
    ) {
        $this->doctrine                         = $doctrine;
        $this->eventDispatcher                  = $eventDispatcher;
        $this->securityBridge                   = $securityBridge;
        $this->ordersFactory                    = $ordersFactory;
        $this->ordersRepository                 = $ordersRepository;
        $this->orderItemsFactory                = $orderItemsFactory;
        $this->pricingPlanCategoryRepository    = $pricingPlanCategoryRepository;
        $this->pricingPlansRepository           = $pricingPlansRepository;
        $this->paymentMethodsRepository         = $paymentMethodsRepository;
        $this->subscriptionsRepository          = $subscriptionsRepository;
        $this->vsPayment                        = $vsPayment;
        $this->orderFactory                     = $orderFactory;
        $this->gatewaysRepository               = $gatewaysRepository;
    }
    
    public function showPricingPlans( Request $request ): Response
    {
        $pricingPlanCategories  = $this->pricingPlanCategoryRepository->findAll();
        $activeSubscriptions    = $this->subscriptionsRepository
                                    ->getSubscriptionsByUser( $this->securityBridge->getUser() );
        
        return $this->render( '@VSCatalog/Pages/PricingPlansCheckout/pricing_plans.html.twig', [
            'pricingPlanCategories' => $pricingPlanCategories,
            'subscriptions'         => $activeSubscriptions,
        ]);
    }
    
    public function showSelectPricingPlanForm( $pricingPlanId, Request $request ): Response
    {
        $form                   = $this->createForm( SelectPricingPlanForm::class, null, ['method' => 'POST'] );
        $bankTransferGateway    = $this->gatewaysRepository->findOneBy( ['factoryName' => 'offline_bank_transfer'] );
        
        $pricingPlan            = $this->pricingPlansRepository->find( $pricingPlanId );
        
        return $this->render( '@VSCatalog/Pages/PricingPlansCheckout/Partial/select-pricing-plan-form.html.twig', [
            'form'              => $form->createView(),
            'pricingPlanId'     => $pricingPlanId,
            'pricingPlan'       => $pricingPlan,
            'bankTransferInfo'  => $bankTransferGateway ? $bankTransferGateway->getConfig() : null,
        ]);
    }
    
    public function handlePricingPlanFormAction( Request $request ): Response
    {
        $cart   = $this->orderFactory->getShoppingCart();
        if ( ! $cart ) {
            throw new ShoppingCartException( 'Shopping Cart cannot be created !!!' );
        }
        $this->orderFactory->clearShoppingCart();   // Remove Previous Order Items If Exists
        
        $form   = $this->createForm( SelectPricingPlanForm::class );
        $form->handleRequest( $request );
        if ( $form->isSubmitted() ) {
            $em             = $this->doctrine->getManager();
            $formData       = $form->getData();
            
            $paymentMethod  = $formData['paymentMethod']['paymentMethod'];
            $pricingPlan    = $this->prepareCart( $formData, $cart, $paymentMethod );
            
            $paymentPrepareUrl  = $this->vsPayment->getPaymentPrepareRoute(
                $paymentMethod->getGateway()
            );
            
            return new JsonResponse([
                'status'    => Status::STATUS_OK,
                'data'      => [
                    'paymentPrepareUrl' => $paymentPrepareUrl,
                    'gatewayFactory'    => $paymentMethod->getGateway()->getFactoryName(),
                ]
            ]);
        }
    }
    
    public function showPaymentMethodForm( $pricingPlanId, Request $request ): Response
    {
        $form                   = $this->createForm( SelectPaymentMethodForm::class, null, ['method' => 'POST'] );
        $bankTransferGateway    = $this->gatewaysRepository->findOneBy( ['factoryName' => 'offline_bank_transfer'] );
        
        $template               = '@VSCatalog/Pages/PricingPlansCheckout/select-payment-method.html.twig';
        if ( $request->isXmlHttpRequest() ) {
            $template   = '@VSCatalog/Pages/PricingPlansCheckout/Partial/select-payment-method-form.html.twig';
        }
        
        return $this->render( $template, [
            'form'              => $form->createView(),
            'pricingPlanId'     => $pricingPlanId,
            'bankTransferInfo'  => $bankTransferGateway ? $bankTransferGateway->getConfig() : null,
        ]);
    }
    
    public function handlePaymentMetodFormAction( Request $request ): Response
    {
        $cart   = $this->orderFactory->getShoppingCart();
        if ( ! $cart ) {
            throw new ShoppingCartException( 'Shopping Cart cannot be created !!!' );
        }
        $this->orderFactory->clearShoppingCart();   // Remove Previous Order Items If Exists
        
        $form   = $this->createForm( SelectPaymentMethodForm::class );
        $form->handleRequest( $request );
        if ( $form->isSubmitted() ) {
            $em             = $this->doctrine->getManager();
            $formData       = $form->getData();
            
            $paymentMethod  = $formData['paymentMethod']['paymentMethod'];
            $pricingPlan    = $this->prepareCart( $formData, $cart, $paymentMethod );
            
            $paymentPrepareUrl  = $this->vsPayment->getPaymentPrepareRoute(
                $paymentMethod->getGateway()
            );
            
            if ( $request->isXmlHttpRequest() ) {
                return new JsonResponse([
                    'status'    => Status::STATUS_OK,
                    'data'      => [
                        'paymentPrepareUrl' => $paymentPrepareUrl,
                        'gatewayFactory'    => $paymentMethod->getGateway()->getFactoryName(),
                    ]
                ]);
            }
            
            return $this->redirectToRoute( $paymentPrepareUrl );
        }
    }
    
    protected function prepareCart( $formData, $cart, $paymentMethod )
    {
        $em             = $this->doctrine->getManager();
        $pricingPlan    = $this->pricingPlansRepository->find( $formData['pricingPlan'] );
        
        $subscription   = $this->createSubscription( $pricingPlan, $formData );
        
        if ( ! $subscription ) {
            throw new CheckoutException( 'Subscription Cannot be Created !' );
        }
        
        $orderItem      = $this->orderItemsFactory->createNew();
        
        $subscription->addOrderItem( $orderItem );
        $orderItem->setSubscription( $subscription );
        
        $orderItem->setPrice( $pricingPlan->getPrice() );
        $orderItem->setCurrencyCode( $pricingPlan->getCurrencyCode() );
        $orderItem->setTotal( $pricingPlan->getPrice() );
        
        $cart->addItem( $orderItem );
        
        if ( isset( $formData['paymentMethod']['setRecurringPayments'] ) ) {
            $cart->setRecurringPayment( $formData['paymentMethod']['setRecurringPayments'] );
        }
        
        $cart->setPaymentMethod( $paymentMethod );
        $cart->setDescription( $pricingPlan->getPaymentDescription() );
        
        $em->persist( $cart );
        $em->flush();
        
        return $pricingPlan;
    }
    
    /**
     * For Every Payment Create New Subscription because Subscription / OrderItem Assossiation is OneToOne
     * 
     * @param unknown $pricingPlan
     * @param unknown $formData
     * @return PricingPlanSubscriptionInterface
     */
    protected function createSubscription( $pricingPlan, $formData ): PricingPlanSubscriptionInterface
    {
        $user                   = $this->securityBridge->getUser();
        $setRecurringPayments   = isset( $formData['paymentMethod']['setRecurringPayments'] ) && $formData['paymentMethod']['setRecurringPayments'];
        
        $this->eventDispatcher->dispatch(
            new CreateSubscriptionEvent( $pricingPlan, $setRecurringPayments ),
            CreateSubscriptionEvent::NAME
        );
        
        $this->doctrine->getManager()->refresh( $user );
        $subscriptions  = $this->subscriptionsRepository->getSubscriptionsByUserOnPricingPlan( $user, $pricingPlan );
        
        $subscription   = \end( $subscriptions );
        if ( ! $subscription ) {
            throw new \RuntimeException( "Subscription Cannot be Created !!!" );
        }
        
        return $subscription;
    }
}