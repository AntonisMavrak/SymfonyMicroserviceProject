<?php

namespace App\Filter;

use App\DTO\PromotionEnquiryInterface;

class LowestPriceFilter implements PromotionsFilterInterface
{

    public function apply(PromotionEnquiryInterface $enquiry): PromotionEnquiryInterface
    {
        $enquiry->setPrice(100);
        $enquiry->setDiscountedPrice(50);
        $enquiry->setPromotionId(4);
        $enquiry->setPromotionName('Black Friday half price sale');

        return $enquiry;
    }
}