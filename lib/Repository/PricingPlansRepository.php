<?php namespace Vankosoft\CatalogBundle\Repository;

use Symfony\Component\Intl\Currencies;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class PricingPlansRepository extends EntityRepository
{
    public function findAllForForm(): array
    {
        $results = $this->createQueryBuilder( 'pp' )
            ->where( 'pp.enabled = 1' )
            ->orderBy( 'pp.id', 'ASC' )
            ->getQuery()
            ->getResult()
        ;
            
        $formChoices = [];
        foreach( $results as $pricingPlan ){
            $categoryName   = $pricingPlan->getCategory()->getName();
            if ( ! isset( $formChoices[$categoryName] ) ) {
                $formChoices[$categoryName] = [];
            }
            
            $currencySymbol = Currencies::getSymbol( $pricingPlan->getCurrencyCode() );
            $choiceName     = $pricingPlan->getTitle() . ' - ' . $currencySymbol . $pricingPlan->getPrice();
            
            $formChoices[$categoryName][$choiceName] = $pricingPlan->getId();
        }
        
        return $formChoices;
    }
}