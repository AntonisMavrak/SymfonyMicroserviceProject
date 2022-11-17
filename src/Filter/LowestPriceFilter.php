<?php

namespace App\Filter;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;

class LowestPriceFilter implements PromotionsFilterInterface
{

    public function apply(PromotionEnquiryInterface $enquiry, Promotion ...$promotion): PromotionEnquiryInterface
    {
        $enquiry->setPrice(100);
        $enquiry->setDiscountedPrice(50);
        $enquiry->setPromotionId(4);
        $enquiry->setPromotionName('Black Friday half price sale');

        return $enquiry;
    }
}