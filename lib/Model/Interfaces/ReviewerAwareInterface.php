<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

interface ReviewerAwareInterface
{
    public function _toReviewer(): ReviewerInterface;
}