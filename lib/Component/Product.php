<?php namespace Vankosoft\CatalogBundle\Component;

use Vankosoft\PaymentBundle\Component\Payum\Stripe\Api as StripeApi;

class Product
{
    /** Product Picture Types */
    const PRODUCT_PICTURE_TYPE_THUMBNAIL    = 'product_thumbnail';
    const PRODUCT_PICTURE_TYPE_SLIDER       = 'product_slider_picture';
    const PRODUCT_PICTURE_TYPE_OTHER        = 'product_other_pictures';
    
    /** Product File Types */
    const PRODUCT_FILE_TYPE_CONTENT         = 'product_content';
    const PRODUCT_FILE_TYPE_OTHER           = 'product_other_files';
    
    const PRODUCT_PICTURE_TYPES = [
        self::PRODUCT_PICTURE_TYPE_THUMBNAIL    => 'Product Thumbnail',
        self::PRODUCT_PICTURE_TYPE_SLIDER       => 'Slider Photo',
        self::PRODUCT_PICTURE_TYPE_OTHER        => 'Other Pictures',
    ];
    
    const PRODUCT_FILE_TYPES = [
        self::PRODUCT_FILE_TYPE_CONTENT => 'Product Content',
        self::PRODUCT_FILE_TYPE_OTHER   => 'Other Files',
    ];
    
    const PRICING_PLAN_ATTRIBUTE_KEYS   = [
        StripeApi::PRODUCT_ATTRIBUTE_KEY        => 'Stripe Product ID',
        StripeApi::PRICING_PLAN_ATTRIBUTE_KEY   => 'Stripe Plan ID',
    ];
}