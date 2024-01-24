<?php namespace Vankosoft\CatalogBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;

interface CommenterInterface
{
    public function getComments(): Collection;
}