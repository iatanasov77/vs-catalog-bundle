<?php namespace Vankosoft\CatalogBundle\Component\Promotion\RuleChecker;

use Sylius\Component\Promotion\Checker\Rule\RuleCheckerInterface;
use Sylius\Component\Promotion\Exception\UnsupportedTypeException;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;

use Vankosoft\PaymentBundle\Model\Interfaces\OrderInterface;
use Vankosoft\PaymentBundle\Model\Interfaces\OrderItemInterface;

final class ContainsProductRuleChecker implements RuleCheckerInterface
{
    public const TYPE = 'contains_product';
    
    /**
     * @throws UnsupportedTypeException
     */
    public function isEligible( PromotionSubjectInterface $subject, array $configuration ): bool
    {
        if ( ! $subject instanceof OrderInterface ) {
            throw new UnsupportedTypeException( $subject, OrderInterface::class );
        }
        
        /** @var OrderItemInterface $item */
        foreach ( $subject->getItems() as $item ) {
            if ( $configuration['product_code'] === $item->getProduct()->getCode() ) {
                return true;
            }
        }
        
        return false;
    }
}
