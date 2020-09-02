<?php

namespace Long\SpecialPrice\Model\ResourceModel;

class AdvancedSpecialPrice extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('advanced_special_price', 'entity_id');
    }
}
