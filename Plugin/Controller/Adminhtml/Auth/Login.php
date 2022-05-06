<?php

/**
 * Copyright © Fiko Borizqy. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Fiko\AdminUrl\Plugin\Controller\Adminhtml\Auth;

use Fiko\AdminUrl\Model\ResourceModel\Notification\CollectionFactory;
use Magento\Backend\Controller\Adminhtml\Auth\Login as Subject;
use Magento\Backend\Model\Auth;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class Login
{
    /**
     * Constructor.
     *
     * @param Auth $_auth
     * @param UrlInterface $_backendUrl
     * @param ResponseInterface $response
     * @param PageFactory $resultPageFactory
     * @param CollectionFactory $notificationCollectionFactory
     * @param Http $http
     */
    public function __construct(
        Auth $_auth,
        UrlInterface $_backendUrl,
        ResponseInterface $response,
        PageFactory $resultPageFactory,
        CollectionFactory $notificationCollectionFactory,
        Http $http
    ) {
        $this->_auth = $_auth;
        $this->_backendUrl = $_backendUrl;
        $this->response = $response;
        $this->resultPageFactory = $resultPageFactory;
        $this->notificationCollectionFactory = $notificationCollectionFactory;
        $this->http = $http;
    }

    /**
     * Around method of execute
     *
     * @param \Magento\Backend\Controller\Adminhtml\Auth\Login $subject
     * @param callable $proceed
     * @return void
     */
    public function aroundExecute(Subject $subject, callable $proceed)
    {
        if ($this->_auth->isLoggedIn()) {
            if ($this->_auth->getAuthStorage()->isFirstPageAfterLogin()) {
                $this->_auth->getAuthStorage()->setIsFirstPageAfterLogin(true);
            }

            return $this->response->setRedirect($this->_backendUrl->getStartupPageUrl())->sendResponse();
        }

        if (strpos($this->http->getPathInfo(), 'fiko_adminurl') === false) {
            return $proceed();
        }

        $key = $this->http->getParam('fiko_adminurl');
        $notification = $this->notificationCollectionFactory->create()->addFieldToFilter('key', ['eq' => $key])
            ->getFirstItem();

        if ($notification->isEmpty()) {
            return $proceed();
        }

        return $this->resultPageFactory->create();
    }
}
