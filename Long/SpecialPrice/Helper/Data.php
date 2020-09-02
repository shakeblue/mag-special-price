<?php

namespace Long\SpecialPrice\Helper;

use Magento\Framework\App\Helper\Context;
use \Long\SpecialPrice\Api\Data\AdvancedSpecialPriceInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Long\SpecialPrice\Model\ResourceModel\AdvancedSpecialPrice\CollectionFactory
     */
    protected $specialPriceCollectionFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $dateTime;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    public function __construct(
        Context $context,
        \Long\SpecialPrice\Model\ResourceModel\AdvancedSpecialPrice\CollectionFactory $specialPriceCollectionFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Customer\Model\SessionFactory $customerSessionFactory
    ) {
        parent::__construct($context);
        $this->specialPriceCollectionFactory = $specialPriceCollectionFactory;
        $this->dateTime = $dateTime;
        $this->customerSession = $customerSessionFactory->create();
    }

    /**
     * Get active special price for specific product and customer
     * @param $productId
     * @return AdvancedSpecialPriceInterface|null
     */
    public function getActiveSpecialPrice($productId)
    {
        $customerId = $this->customerSession->getId();
        if ($customerId && $productId) {
            $collection = $this->specialPriceCollectionFactory->create();
            $collection->addFieldToFilter('customer_id', $customerId);
            $collection->addFieldToFilter('product_id', $productId);
            /**
             * @var AdvancedSpecialPriceInterface $specialPrice
             */
            $specialPrice = $collection->getFirstItem();
            if ($specialPrice->getId() && $this->isActive($specialPrice)) {
                return $specialPrice;
            } else {
                return null;
            }
        }

        return null;
    }

    /**
     * Check if current special price is in active period
     * @param AdvancedSpecialPriceInterface $specialPrice
     * @return bool
     */
    private function isActive(AdvancedSpecialPriceInterface $specialPrice)
    {
        $now = $this->dateTime->date();
        $tomorrow = $this->dateTime->timestamp('+1 day');
        $startDate = $specialPrice->getStartDate() ? $this->dateTime->date($specialPrice->getStartDate()) : $now;
        $endDate = $specialPrice->getEndDate() ? $this->dateTime->date($specialPrice->getEndDate()) : $tomorrow;

        if ($startDate <= $now && $now < $endDate) {
            return true;
        }

        return false;
    }
}
