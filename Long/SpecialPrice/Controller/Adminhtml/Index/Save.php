<?php

namespace Long\SpecialPrice\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
class Save extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Long\SpecialPrice\Api\SpecialPriceRepositoryInterface
     */
    protected $specialPriceRepository;

    /**
     * @var \Long\SpecialPrice\Model\AdvancedSpecialPriceFactory
     */
    protected $specialPriceFactory;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Framework\App\Cache\Tag\Resolver
     */
    protected $tagResolver;

    /**
     * @var \Magento\Framework\App\Cache\StateInterface
     */
    protected $cacheState;

    /**
     * @var \Magento\Framework\App\Cache\Type\FrontendPool
     */
    protected $frontendPool;


    /**
     * Save constructor.
     * @param Context $context
     * @param \Long\SpecialPrice\Model\AdvancedSpecialPriceFactory $specialPriceFactory
     * @param \Long\SpecialPrice\Api\SpecialPriceRepositoryInterface $specialPriceRepository
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Context $context,
        \Long\SpecialPrice\Model\AdvancedSpecialPriceFactory $specialPriceFactory,
        \Long\SpecialPrice\Api\SpecialPriceRepositoryInterface $specialPriceRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\App\Cache\Tag\Resolver $tagResolver,
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Framework\App\Cache\Type\FrontendPool $frontendPool

    ) {
        $this->specialPriceFactory = $specialPriceFactory;
        $this->specialPriceRepository = $specialPriceRepository;
        $this->productRepository = $productRepository;
        $this->tagResolver = $tagResolver;
        $this->cacheState = $cacheState;
        $this->frontendPool = $frontendPool;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data && $data['product_id']) {
            $specialPrice = $this->specialPriceFactory->create();
            $specialPrice->setData($data);
            try {
                $this->specialPriceRepository->save($specialPrice);
                $product = $this->productRepository->getById($data['product_id']);
                //todo move into after save
                $this->flushCacheByTags($product);
            } catch (\Exception $exception) {
                // todo
                $this->messageManager->addErrorMessage($exception->getMessage());
            }
        }

        return $this->_redirect('*/*/index');
    }

    /**
     * flush cache by tags
     * @param $product
     */
    private function flushCacheByTags($product)
    {
        $tags = $this->tagResolver->getTags($product);
        $cacheList = ['block_html', 'full_page'];
        if (!$tags) {
            return;
        }
        foreach ($cacheList as $cacheType) {
            if ($this->cacheState->isEnabled($cacheType)) {
                $this->frontendPool->get($cacheType)->clean(
                    \Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG,
                    \array_unique($tags)
                );
            }
        }
    }

}
