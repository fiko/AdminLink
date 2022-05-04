<?php

/**
 * Copyright © Fiko Borizqy. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Fiko\AdminUrl\Controller\Adminhtml\Go;

use Fiko\AdminUrl\Model\NotificationFactory;
use Fiko\AdminUrl\Model\ResourceModel\Notification\CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Url;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;

class To extends \Magento\Backend\App\Action
{
    /**
     * Constructor
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param Http $http
     * @param NotificationFactory $notificationFactory
     * @param Url $url
     * @param ResultFactory $resultFactory
     * @param ResponseInterface $response
     * @param CollectionFactory $notificationCollectionFactory
     * @param RedirectFactory $resultRedirectFactory
     */
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
     * Check url keys. If non valid - redirect.
     *
     * @return bool
     *
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

        if ($notification->isEmpty()) {
            return parent::_processUrlKeys();
        }

        if (!$this->_auth->isLoggedIn()) {
            $url = $this->url->getUrl('admin/index/index', ['fiko_adminurl' => $key]);
            $this->response->setRedirect($url)->sendResponse();

            return false;
        }

        $this->response->setRedirect($this->url->getUrl($notification->getDestination()))->sendResponse();

        return false;
    }

    /**
     * Always redirect to homepage if failed to validate URL.
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
