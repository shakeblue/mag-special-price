<?php

namespace Long\SpecialPrice\Pricing\Render;

class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    public function hasAdvancedSpecialPrice()
    {
        $product = $this->getSaleableItem();
        //Get Object Manager Instance
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /**
         * @var \Long\SpecialPrice\Helper\Data $specialPriceHelper
         */
        $specialPriceHelper = $objectManager->create('Long\SpecialPrice\Helper\Data');

        return $specialPriceHelper->getActiveSpecialPrice($product->getId());
    }
}
