<?php

namespace Long\SpecialPrice\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;

class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Long\SpecialPrice\Api\SpecialPriceRepositoryInterface
     */
    protected $specialPriceRepository;

    /**
     * @var \Long\SpecialPrice\Model\AdvancedSpecialPriceFactory
     */
    protected $specialPriceFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Edit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Long\SpecialPrice\Model\AdvancedSpecialPriceFactory $specialPriceFactory
     * @param \Long\SpecialPrice\Api\SpecialPriceRepositoryInterface $specialPriceRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Long\SpecialPrice\Model\AdvancedSpecialPriceFactory $specialPriceFactory,
        \Long\SpecialPrice\Api\SpecialPriceRepositoryInterface $specialPriceRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->specialPriceRepository = $specialPriceRepository;
        $this->specialPriceFactory = $specialPriceFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');

        // 2. Initial checking
        if ($id) {
            $model = $this->specialPriceRepository->getById($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This special price no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->coreRegistry->register('special_price', $model);

        // 5. Build edit form
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Special Price'));
        return $resultPage;
    }
}
