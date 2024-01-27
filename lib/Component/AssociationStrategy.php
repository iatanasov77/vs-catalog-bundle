<?php namespace Vankosoft\CatalogBundle\Component;

use Symfony\Contracts\Translation\TranslatorInterface;

class AssociationStrategy
{
    const STRATEGY_ASSOCIATED   = 'strategy_associated';
    const STRATEGY_RANDOM       = 'strategy_random';
    const STRATEGY_SIMILAR      = 'strategy_similar';
    
    public function __construct(
        TranslatorInterface $translator
    ) {
        $this->translator   = $translator;
    }
    
    public function getStrategies()
    {
        return [
            self::STRATEGY_ASSOCIATED   => $this->translator->trans( 'vs_catalog.association_type.associated', [], 'VSCatalogBundle' ),
            self::STRATEGY_RANDOM       => $this->translator->trans( 'vs_catalog.association_type.random', [], 'VSCatalogBundle' ),
            self::STRATEGY_SIMILAR      => $this->translator->trans( 'vs_catalog.association_type.similar', [], 'VSCatalogBundle' ),
        ];
    }
}