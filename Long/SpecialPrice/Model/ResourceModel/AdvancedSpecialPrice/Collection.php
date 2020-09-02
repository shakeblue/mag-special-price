<?php
namespace Long\SpecialPrice\Model\ResourceModel\AdvancedSpecialPrice;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\Long\SpecialPrice\Model\AdvancedSpecialPrice::class, \Long\SpecialPrice\Model\ResourceModel\AdvancedSpecialPrice::class);
    }
}
