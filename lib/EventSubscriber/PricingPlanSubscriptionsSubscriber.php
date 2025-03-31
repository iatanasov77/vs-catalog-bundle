<?php namespace Vankosoft\CatalogBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Resource\Factory\Factory;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\CacheItemPoolInterface;
use Vankosoft\UsersBundle\Security\SecurityBridge;
use Vankosoft\PaymentBundle\Component\OrderFactory;
use Vankosoft\PaymentBundle\Component\Payum\Stripe\Api as StripeApi;
use Vankosoft\PaymentBundle\Component\Payment\Payment;

use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanSubscriptionInterface;
use Vankosoft\CatalogBundle\EventSubscriber\Event\SubscriptionsPaymentDoneEvent;
use Vankosoft\CatalogBundle\EventSubscriber\Event\CreateSubscriptionEvent;
use Vankosoft\CatalogBundle\EventSubscriber\Event\CreateNewUserSubscriptionEvent;

/**
 * MANUAL: https://q.agency/blog/custom-events-with-symfony5/
 */
final class PricingPlanSubscriptionsSubscriber implements EventSubscriberInterface
{
    /** @var ManagerRegistry */
    private $doctrine;
    
    /** @var CacheItemPoolInterface */
    private $cache;
    
    /** @var SecurityBridge */
    private $securityBridge;
    
    /** @var RepositoryInterface */
    private $pricingPlanSubscriptionRepository;
    
    /** @var Factory */
    private $pricingPlanSubscriptionFactory;
    
    /** @vvar OrderFactory */
    private $orderFactory;
    
    /** @var StripeApi */
    private $stripeApi;
    
    /** @var Payment */
    private $vsPayment;
    
    public function __construct(
        ManagerRegistry $doctrine,
        CacheItemPoolInterface $cache,
        SecurityBridge $securityBridge,
        OrderFactory $orderFactory,
        StripeApi $stripeApi,
        Payment $vsPayment,
        RepositoryInterface $pricingPlanSubscriptionRepository,
        Factory $pricingPlanSubscriptionFactory,
    ) {
        $this->doctrine                             = $doctrine;
        $this->cache                                = $cache;
        $this->securityBridge                       = $securityBridge;
        $this->pricingPlanSubscriptionRepository    = $pricingPlanSubscriptionRepository;
        $this->pricingPlanSubscriptionFactory       = $pricingPlanSubscriptionFactory;
        $this->orderFactory                         = $orderFactory;
        $this->stripeApi                            = $stripeApi;
        $this->vsPayment                            = $vsPayment;
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            CreateSubscriptionEvent::NAME           => 'createSubscription',
            CreateNewUserSubscriptionEvent::NAME    => 'createNewUserSubscription',
            SubscriptionsPaymentDoneEvent::NAME     => 'setSubscriptionsPayment',
        ];
    }

    public function createSubscription( CreateSubscriptionEvent $event )
    {
        $pricingPlan    = $event->getPricingPlan();
        $user           = $this->securityBridge->getUser();
        
        $subscription   = $user->getPricingPlanSubscriptions()->get( $pricingPlan->getId() );
        if ( ! $subscription )  {
//             $this->debugLog( 'subscription-found', ' NOT FOUND' );
            
            $subscription   = $this->pricingPlanSubscriptionFactory->createNew();
            
            $subscription->setUser( $user );
            $subscription->setPricingPlan( $pricingPlan );
            $subscription->setRecurringPayment( $event->getSetRecurringPayments() );
        }
        
        $subscription->setPrice( $pricingPlan->getPrice() );
        $subscription->setCurrency( $pricingPlan->getCurrency() );
        
        $em = $this->doctrine->getManager();
        $em->persist( $subscription );
        $em->flush();
    }
    
    public function createNewUserSubscription( CreateNewUserSubscriptionEvent $event )
    {
        $pricingPlan    = $event->getPricingPlan();
        $subscription   = $this->pricingPlanSubscriptionFactory->createNew();
        
        $subscription->setUser( $event->getUser() );
        $subscription->setPricingPlan( $pricingPlan );
        
        $subscription->setPrice( $pricingPlan->getPrice() );
        $subscription->setCurrency( $pricingPlan->getCurrency() );
        
        $em             = $this->doctrine->getManager();
        $em->persist( $subscription );
        $em->flush();
    }
    
    public function setSubscriptionsPayment( SubscriptionsPaymentDoneEvent $event )
    {
        $em = $this->doctrine->getManager();
        
        foreach ( $event->getSubscriptions() as $subscription ) {
            $this->setSubscriptionPaid( $subscription, $event->getPayment() );
        }
        
        $em->flush();
    }
    
    private function setSubscriptionPaid( PricingPlanSubscriptionInterface $subscription, $payment )
    {
        $user                   = $this->securityBridge->getUser();
        
        $gateway    = $payment->getOrder()->getPaymentMethod()->getGateway();
        
        if ( $this->vsPayment->isGatewaySupportRecurring( $gateway ) ) {
            $paymentData    = $payment->getDetails();
            $gtAttributes   = $subscription->getGatewayAttributes();
            $gtAttributes   = $gtAttributes ?: [];
            
            $paymentFactory = $gateway->getFactoryName();
            if ( $paymentFactory == 'stripe_checkout' || $paymentFactory == 'stripe_js' ) {
                $this->setStripePaymentAttributes( $subscription, $paymentData );
            }
        }
        
        $now            = new \DateTime();
        $startDate      = $subscription->isPaid() && $subscription->getExpiresAt() > $now ?
                            $subscription->getExpiresAt() :
                            $now;
        $expiresDate    = \DateTimeImmutable::createFromMutable( $startDate )->add( $pricingPlan->getSubscriptionPeriod() );
        $subscription->setExpiresAt( $expiresDate );
        
//         $this->debugLog( 'subscription-start-date', $startDate->format( 'Y-m-d H:i:s' ) );
//         $this->debugLog( 'subscription-expires-date', $expiresDate->format( 'Y-m-d H:i:s' ) );
//         $this->debugLog( 'subscription-period', $pricingPlan->getSubscriptionPeriod()->format( '%a total days' ) );
        
        $this->doctrine->getManager()->persist( $subscription );
    }
    
    private function setStripePaymentAttributes( &$subscription, $paymentData )
    {
        $gtAttributes[StripeApi::CUSTOMER_ATTRIBUTE_KEY]    = isset( $paymentData['local']['customer'] ) ?
                                                                $paymentData['local']['customer']['id'] : null;
        
        $gtAttributes[StripeApi::PRICE_ATTRIBUTE_KEY]       = isset( $paymentData['local']['customer']['plan'] ) ?
                                                                $paymentData['local']['customer']['plan'] : null;
        
        if ( $gtAttributes[StripeApi::CUSTOMER_ATTRIBUTE_KEY] && $gtAttributes[StripeApi::PRICE_ATTRIBUTE_KEY] ) {
            $stripeSubscriptions                                    = $this->stripeApi->getSubscriptions([
                'customer'  => $gtAttributes[StripeApi::CUSTOMER_ATTRIBUTE_KEY],
                'price'     => $gtAttributes[StripeApi::PRICE_ATTRIBUTE_KEY],
            ]);
            $gtAttributes[StripeApi::SUBSCRIPTION_ATTRIBUTE_KEY]    = ! empty( $stripeSubscriptions ) ?
                                                                        $stripeSubscriptions[0]['id'] : null;
        }
            
        $subscription->setGatewayAttributes( $gtAttributes );
    }
    
    private function debugLog( $cacheKey, $cacheData ): void
    {
        $cache      = $this->cache->getItem( $cacheKey );
        $cache->set( $cacheData );
        
        $this->cache->save( $cache );
    }
}
