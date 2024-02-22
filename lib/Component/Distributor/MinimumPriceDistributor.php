<?php namespace Vankosoft\CatalogBundle\Component\Distributor;

use Webmozart\Assert\Assert;
use Vankosoft\PaymentBundle\Component\Distributor\ProportionalIntegerDistributorInterface;
use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationInterface;
use Vankosoft\PaymentBundle\Model\Interfaces\OrderItemInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ProductInterface;

final class MinimumPriceDistributor implements MinimumPriceDistributorInterface
{
    /** @var ProportionalIntegerDistributorInterface */
    private $proportionalIntegerDistributor;
    
    public function __construct( ProportionalIntegerDistributorInterface $proportionalIntegerDistributor )
    {
        $this->proportionalIntegerDistributor   = $proportionalIntegerDistributor;
    }

    public function distribute( array $orderItems, int $amount, ApplicationInterface $application, bool $appliesOnDiscounted ): array
    {
        Assert::allIsInstanceOf( $orderItems, OrderItemInterface::class );

        $orderItemsToProcess = [];
        foreach ( $orderItems as $index => $orderItem ) {
            /** @var ProductInterface $product */
            $product = $orderItem->getProduct();

            //$minimumPrice = $product->getChannelPricingForChannel( $application )->getMinimumPrice();
            $minimumPrice = 0;
            
            $minimumPrice *= $orderItem->getQuantity();

            $orderItemsToProcess['order-item-' . $index] = [
                'orderItem'     => $orderItem,
                'minimumPrice'  => $minimumPrice,
            ];
        }

        return array_values( array_map(
            function ( array $processedOrderItem ): int { return $processedOrderItem['promotion']; },
            $this->processDistributionWithMinimumPrice( $orderItemsToProcess, $amount, $channel, $appliesOnDiscounted ),
        ));
    }

    private function processDistributionWithMinimumPrice( array $orderItems, int $amount, $application, bool $appliesOnDiscounted ): array
    {
        $totals = array_values( array_map( function ( array $orderItemData ) use ( $appliesOnDiscounted, $application ): int {
            return $this->getTotalPrice( $orderItemData['orderItem'], $appliesOnDiscounted, $application );
        }, $orderItems));

        $promotionsToDistribute = array_combine(
            array_keys( $orderItems ),
            $this->proportionalIntegerDistributor->distribute( $totals, $amount ),
        );

        foreach ( $promotionsToDistribute as $index => $promotion ) {
            $orderItems[$index]['promotion'] = $promotion;
        }

        $leftAmount = 0;
        $distributableItems = [];
        foreach ( $orderItems as $index => $distribution ) {
            /** @var OrderItemInterface $orderItem */
            $orderItem = $distribution['orderItem'];
            $minimumPriceAdjustedByCurrentDiscount = $distribution['minimumPrice'];
            $proposedPromotion = $distribution['promotion'];

            if ( $this->exceedsOrderItemMinimumPrice( $orderItem->getTotal(), $minimumPriceAdjustedByCurrentDiscount, $proposedPromotion ) ) {
                $leftAmount += ( $orderItem->getTotal() + $proposedPromotion ) - ( $minimumPriceAdjustedByCurrentDiscount );
                $orderItems[$index]['promotion'] = $minimumPriceAdjustedByCurrentDiscount - $orderItem->getTotal();

                continue;
            }

            $distributableItems[$index] = [
                'orderItem'     => $orderItem,
                'minimumPrice'  => $distribution['minimumPrice'] - $proposedPromotion,
            ];
        }

        if ( $leftAmount === 0 || empty( $distributableItems ) ) {
            return $orderItems;
        }

        $nestedDistributions = $this->processDistributionWithMinimumPrice( $distributableItems, $leftAmount, $application, $appliesOnDiscounted );

        foreach ( $nestedDistributions as $index => $distribution ) {
            $orderItems[$index]['promotion'] += $distribution['promotion'];
        }

        return $orderItems;
    }

    private function exceedsOrderItemMinimumPrice(
        int $orderItemTotal,
        int $minimumPriceAdjustedByCurrentDiscount,
        int $proposedPromotion,
    ): bool {
        return $minimumPriceAdjustedByCurrentDiscount >= ( $orderItemTotal + $proposedPromotion );
    }

    private function getTotalPrice( OrderItemInterface $orderItem, bool $appliesOnDiscounted, ChannelInterface $channel ): int
    {
        $product = $orderItem->getProduct();
        if ( $appliesOnDiscounted === false && !$product->getAppliedPromotionsForChannel( $channel )->isEmpty() ) {
            return 0;
        }

        return $orderItem->getTotal();
    }
}
