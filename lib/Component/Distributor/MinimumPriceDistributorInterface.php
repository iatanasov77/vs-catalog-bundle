<?php namespace Vankosoft\CatalogBundle\Component\Distributor;

use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationInterface;

interface MinimumPriceDistributorInterface
{
    public function distribute( array $orderItems, int $amount, ApplicationInterface $application, bool $appliesOnDiscounted ): array;
}
