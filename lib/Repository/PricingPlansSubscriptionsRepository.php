<?php namespace Vankosoft\CatalogBundle\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Vankosoft\CatalogBundle\Model\Interfaces\UserSubscriptionAwareInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\PricingPlanInterface;

class PricingPlansSubscriptionsRepository extends EntityRepository
{
    /*
     * MANUAL: https://www.boxuk.com/insight/filtering-associations-with-doctrine-2/
     *          THERE IS AN EXAMPLE HOW TO FILTER COLLECTION IN ENTITY CLASS
     */
    public function getActiveSubscriptionsByUser( ?UserSubscriptionAwareInterface $user )
    {
        if ( ! $user ) {
            return [];
        }
        
        $qb = $this->createQueryBuilder( 'pps' )
                    ->innerJoin( 'pps.user', 'u' )
                    ->where( 'u.id = :userId' )
                    ->andWhere( 'pps.active = 1' )
                    ->setParameter( 'userId', $user->getId() );
        
        return $qb->getQuery()->getResult();
    }
    
    public function getSubscriptionsByUser( ?UserSubscriptionAwareInterface $user )
    {
        $subscriptions  = [];
        if ( ! $user ) {
            return $subscriptions;
        }
        
        $collection     = $user->getPricingPlanSubscriptions();
        foreach ( $collection as $subscription ) {
            $subscriptions[$subscription->getServiceCode()]    = $subscription;
        }
        
        return $subscriptions;
    }
    
    public function getSubscribedServicesByUser( ?UserSubscriptionAwareInterface $user )
    {
        $subscriptions  = [];
        if ( ! $user ) {
            return $subscriptions;
        }
        
        $collection     = $user->getPricingPlanSubscriptions();
        foreach ( $collection as $subscription ) {
            if ( ! isset( $subscriptions[$subscription->getServiceCode()] ) ) {
                $subscriptions[$subscription->getServiceCode()] = [];
            }
            $subscriptions[$subscription->getServiceCode()][$subscription->getPeriodCode()]    = $subscription;
        }
        
        return $subscriptions;
    }
    
    public function getSubscriptionsByUserOnPricingPlan( ?UserSubscriptionAwareInterface $user, PricingPlanInterface $pricingPlan )
    {
        if ( ! $user ) {
            return [];
        }
        
        $subscriptions  = $this->findBy( ['user' => $user, 'pricingPlan' => $pricingPlan] );
        
        return $subscriptions;
    }
}