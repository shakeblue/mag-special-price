<?php

namespace Long\SpecialPrice\Api\Data;

interface AdvancedSpecialPriceInterface
{
    const CUSTOMER_ID = 'customer_id';
    const PRODUCT_ID = 'product_id';
    const PRICE = 'price';
    const START_DATE = 'start_date';
    const END_DATE = 'end_date';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @param int $productId
     * @return $this
     */
    public function setProductId($productId);

    /**
     * @return mixed
     */
    public function getPrice();

    /**
     * @param $price
     * @return mixed
     */
    public function setPrice($price);

    /**
     * @return string
     */
    public function getStartDate();

    /**
     * @param string $startDate
     * @return $this
     */
    public function setStartDate($startDate);

    /**
     * @return string
     */
    public function getEndDate();

    /**
     * @param string $endDate
     * @return $this
     */
    public function setEndDate($endDate);
}
