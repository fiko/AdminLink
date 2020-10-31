<?php

namespace Fiko\AdminUrl\Controller\Adminhtml\Go;

use Magento\Backend\App\Action\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Request\Http;
use Fiko\AdminUrl\Model\NotificationFactory;
use Magento\Backend\Model\Url;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;
use Fiko\AdminUrl\Model\ResourceModel\Notification\CollectionFactory;
use Magento\Framework\Controller\Result\RedirectFactory;

class To extends \Magento\Backend\App\Action
{
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        Http $http,
        NotificationFactory $notificationFactory,
        Url $url,
        ResultFactory $resultFactory,
        ResponseInterface $response,
        CollectionFactory $notificationCollectionFactory,
        RedirectFactory $resultRedirectFactory
    ) {
        $this->storeManager = $storeManager;
        $this->http = $http;
        $this->notificationFactory = $notificationFactory;
        $this->url = $url;
        $this->resultFactory = $resultFactory;
        $this->response = $response;
        $this->notificationCollectionFactory = $notificationCollectionFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;

        parent::__construct($context);
    }

    /**
     * Check url keys. If non valid - redirect
     *
     * @return bool
     * @see \Magento\Backend\App\Request\BackendValidator for default
     * request validation.
     */
    public function _processUrlKeys()
    {
        $key = $this->http->getParam('key');
        $path = $this->http->getPathInfo();
        $destination = substr($path, strpos($path, $key) + strlen($key) + 1);
        $notification = $this->notificationCollectionFactory->create()->addFieldToFilter('key', ['eq' => $key])
            ->addFieldToFilter('destination', ['eq' => $destination])->getFirstItem();

        if ($notification->isEmpty()) return parent::_processUrlKeys();

        if (!$this->_auth->isLoggedIn()) {
            $url = $this->url->getUrl('admin/index/index', ['fiko_adminurl' => $key]);
            $this->response->setRedirect($url)->sendResponse();
            return false;
        }

        $this->response->setRedirect($this->url->getUrl($notification->getDestination()))->sendResponse();
        return false;
    }

    /**
     * Always redirect to homepage if failed to validate URL
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('');
        return $resultRedirect;
    }
}
