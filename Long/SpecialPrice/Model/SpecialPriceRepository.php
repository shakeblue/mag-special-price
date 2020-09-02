<?php

namespace Long\SpecialPrice\Model;

use Long\SpecialPrice\Api\Data\AdvancedSpecialPriceInterface;
use Long\SpecialPrice\Model\ResourceModel\AdvancedSpecialPrice as SpecialPriceResource;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;

class SpecialPriceRepository implements \Long\SpecialPrice\Api\SpecialPriceRepositoryInterface
{
    /**
     * @var \Long\SpecialPrice\Model\AdvancedSpecialPriceFactory
     */
    protected $specialPriceModelFactory;

    /**
     * @var SpecialPriceResource
     */
    protected $specialPriceResource;

    public function __construct(
        \Long\SpecialPrice\Model\AdvancedSpecialPriceFactory $specialPriceModelFactory,
        SpecialPriceResource $specialPriceResource
    ) {
        $this->specialPriceModelFactory = $specialPriceModelFactory;
        $this->specialPriceResource = $specialPriceResource;
    }

    /**
     * @param int $id
     * @return AdvancedSpecialPriceInterface
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $specialPriceModel = $this->specialPriceModelFactory->create();
        $this->specialPriceResource->load($specialPriceModel, $id);
        if (!$specialPriceModel->getId()) {
            throw new NoSuchEntityException(__('Unable to find special price with ID "%1"', $id));
        }
        return $specialPriceModel;
    }

    /**
     * @param AdvancedSpecialPriceInterface $specialPrice
     * @return AdvancedSpecialPriceInterface
     * @throws CouldNotSaveException
     */
    public function save(AdvancedSpecialPriceInterface $specialPrice)
    {
        try {
            $this->specialPriceResource->save($specialPrice);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $specialPrice;
    }

    /**
     * @param AdvancedSpecialPriceInterface $specialPrice
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(AdvancedSpecialPriceInterface $specialPrice)
    {
        try {
            $this->specialPriceResource->delete($specialPrice);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }
}
