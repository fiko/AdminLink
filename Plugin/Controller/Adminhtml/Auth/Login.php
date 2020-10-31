<?php

namespace Fiko\AdminUrl\Plugin\Controller\Adminhtml\Auth;

use Magento\Backend\Model\Auth;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Fiko\AdminUrl\Model\ResourceModel\Notification\CollectionFactory;
use Magento\Framework\App\Request\Http;

class Login
{
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

    public function aroundExecute(
        \Magento\Backend\Controller\Adminhtml\Auth\Login $subject,
        callable $proceed
    ) {
        if ($this->_auth->isLoggedIn()) {
            if ($this->_auth->getAuthStorage()->isFirstPageAfterLogin()) {
                $this->_auth->getAuthStorage()->setIsFirstPageAfterLogin(true);
            }
            return $this->response->setRedirect($this->_backendUrl->getStartupPageUrl())->sendResponse();
        }

        if (strpos($this->http->getPathInfo(), 'fiko_adminurl') === false) return $proceed();

        $key = $this->http->getParam('fiko_adminurl');
        $notification = $this->notificationCollectionFactory->create()->addFieldToFilter('key', ['eq' => $key])
            ->getFirstItem();

        if ($notification->isEmpty()) return $proceed();

        return $this->resultPageFactory->create();
    }
}
