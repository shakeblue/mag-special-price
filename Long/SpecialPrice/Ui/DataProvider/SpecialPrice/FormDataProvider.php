<?php

namespace Long\SpecialPrice\Ui\DataProvider\SpecialPrice;

use Long\SpecialPrice\Model\ResourceModel\AdvancedSpecialPrice\CollectionFactory;

class FormDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $loadedData;
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;
    /**
     * @var \Long\SpecialPrice\Model\AdvancedSpecialPriceFactory
     */
    protected $specialPriceFactory;

    /**
     * FormDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $advancedSpecialPriceCollectionFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Long\SpecialPrice\Model\AdvancedSpecialPriceFactory $specialPriceFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $advancedSpecialPriceCollectionFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\RequestInterface $request,
        \Long\SpecialPrice\Model\AdvancedSpecialPriceFactory $specialPriceFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $advancedSpecialPriceCollectionFactory->create();
        $this->registry = $registry;
        $this->request = $request;
        $this->specialPriceFactory = $specialPriceFactory;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $specialPrice = $this->getCurrentSpecialPrice();
        if ($specialPrice) {
            $this->loadedData[$specialPrice->getId()] = $specialPrice->getData();
        }

        return $this->loadedData;
    }

    /**
     * @return \Long\SpecialPrice\Model\AdvancedSpecialPrice|mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrentSpecialPrice()
    {
        $specialPrice = $this->registry->registry('special_price');
        if ($specialPrice) {
            return $specialPrice;
        }
        $requestId = $this->request->getParam($this->requestFieldName);
        if ($requestId) {
            $specialPrice = $this->specialPriceFactory->create();
            $specialPrice->load($requestId);
            if (!$specialPrice->getId()) {
                throw \Magento\Framework\Exception\NoSuchEntityException::singleField('id', $requestId);
            }
        }
        return $specialPrice;
    }
}
