<?php

namespace Long\SpecialPrice\Api;

use Long\SpecialPrice\Api\Data\AdvancedSpecialPriceInterface;

interface SpecialPriceRepositoryInterface
{
    /**
     * @param int $id
     * @return AdvancedSpecialPriceInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param AdvancedSpecialPriceInterface $specialPrice
     * @return AdvancedSpecialPriceInterface
     */
    public function save(AdvancedSpecialPriceInterface $specialPrice);

    /**
     * @param  AdvancedSpecialPriceInterface $specialPrice
     * @return void
     */
    public function delete(AdvancedSpecialPriceInterface $specialPrice);
}
