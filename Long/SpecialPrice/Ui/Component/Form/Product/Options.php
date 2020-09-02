<?php

namespace Long\SpecialPrice\Ui\Component\Form\Product;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\App\RequestInterface;

/**
 * Options tree for "product" field
 */
class Options implements OptionSourceInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var array
     */
    protected $productTree;

    /**
     * @param ProductCollectionFactory $productCollectionFactory
     * @param RequestInterface $request
     */
    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        RequestInterface $request
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getProductTree();
    }

    /**
     * Retrieve product tree
     *
     * @return array
     */
    protected function getProductTree()
    {
        if ($this->productTree === null) {
            $collection = $this->productCollectionFactory->create();
            $collection->addFieldToFilter('type_id', 'simple');
            $collection->addAttributeToSelect('name');
            $productById = [];
            foreach ($collection as $product) {
                $productId = $product->getEntityId();
                if (!isset($productById[$productId])) {
                    $productById[$productId] = [
                        'value' => $productId
                    ];
                }
                $productById[$productId]['label'] = $product->getName();
            }
            $this->productTree = $productById;
        }
        return $this->productTree;
    }
}

