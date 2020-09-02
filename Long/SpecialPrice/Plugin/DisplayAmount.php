<?php

namespace Long\SpecialPrice\Plugin;

class DisplayAmount
{
    /**
     * @var \Long\SpecialPrice\Helper\Data
     */
    protected $specialPriceHelperData;

    public function __construct(
        \Long\SpecialPrice\Helper\Data $specialPriceHelperData
    ) {
        $this->specialPriceHelperData = $specialPriceHelperData;
    }

    /**
     * @param \Magento\Framework\Pricing\Render\Amount $amount
     * @param $result
     * @return mixed
     */
    public function afterGetDisplayValue(\Magento\Framework\Pricing\Render\Amount $amount, $result)
    {
        $productId = $amount->getSaleableItem()->getId();
        if ($productId) {
            /**
             * @var \Long\SpecialPrice\Api\Data\AdvancedSpecialPriceInterface $specialPrice
             */
            $specialPrice = $this->specialPriceHelperData->getActiveSpecialPrice($productId);
            if ($specialPrice && $specialPrice->getPrice()) {
                return $specialPrice->getPrice();
            }
        }

        return $result;
    }
}
