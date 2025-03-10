<?php namespace Vankosoft\CatalogBundle\Component;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Resource\Factory\Factory;
use Sylius\Component\Review\Model\ReviewableInterface;
use Vankosoft\UsersBundle\Security\SecurityBridge;
use Vankosoft\CatalogBundle\Model\Interfaces\ReviewerAwareInterface;
use Vankosoft\CatalogBundle\Model\Interfaces\ReviewInterface;
use Vankosoft\CatalogBundle\Component\Exception\ReviewException;

class ReviewFactory
{
    /** @var SecurityBridge */
    private $securityBridge;
    
    /** @var RepositoryInterface */
    private $reviewsRepository;
    
    /** @var Factory */
    private $reviewsFactory;
    
    public function __construct(
        SecurityBridge $securityBridge,
        RepositoryInterface $reviewsRepository,
        Factory $reviewsFactory
    ) {
        $this->securityBridge       = $securityBridge;
        $this->reviewsRepository    = $reviewsRepository;
        $this->reviewsFactory       = $reviewsFactory;
    }
    
    public function createReview( ReviewableInterface $reviewSubject ): ReviewInterface
    {
        $user   = $this->securityBridge->getUser();
        if ( ! ( $user instanceof ReviewerAwareInterface ) ) {
            throw new ReviewException( 'The User Entity Should Implement \'ReviewerAwareInterface\'' );
        }
        
        $review = $this->reviewsFactory->createNew();
        $review->setReviewSubject( $reviewSubject );
        
        return $review;
    }
}