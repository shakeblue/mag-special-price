<?php

namespace Long\SpecialPrice\Model;

use Long\SpecialPrice\Api\Data\AdvancedSpecialPriceInterface;

class AdvancedSpecialPrice extends \Magento\Framework\Model\AbstractModel implements AdvancedSpecialPriceInterface
{
    protected function _construct()
    {
        $this->_init('Long\SpecialPrice\Model\ResourceModel\AdvancedSpecialPrice');
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->_getData('entity_id');
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData('entity_id', $id);
    }

    /**
     * @inheritdoc
     */
    public function getCustomerId()
    {
        return $this->_getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritdoc
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @inheritdoc
     */
    public function getProductId()
    {
        return $this->_getData(self::PRODUCT_ID);
    }

    /**
     * @inheritdoc
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @inheritdoc
     */
    public function getPrice()
    {
        return $this->_getData(self::PRICE);
    }

    /**
     * @inheritdoc
     */
    public function setPrice($price)
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * @inheritdoc
     */
    public function getStartDate()
    {
        return $this->_getData(self::START_DATE);
    }

    /**
     * @inheritdoc
     */
    public function setStartDate($startDate)
    {
        return $this->setData(self::START_DATE, $startDate);
    }

    /**
     * @inheritdoc
     */
    public function getEndDate()
    {
        return $this->getData(self::END_DATE);
    }

    /**
     * @inheritdoc
     */
    public function setEndDate($endDate)
    {
        return $this->setData(self::END_DATE, $endDate);
    }
}
