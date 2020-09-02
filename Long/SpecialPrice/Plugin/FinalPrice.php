<?php

namespace Long\SpecialPrice\Plugin;

class FinalPrice
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
     * @param \Magento\Catalog\Model\Product $product
     * @param $result
     * @return mixed
     */
    public function afterGetFinalPrice(\Magento\Catalog\Model\Product $product, $result)
    {
        $productId = $product->getId();
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
