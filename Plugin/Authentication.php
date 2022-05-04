<?php

/**
 * Copyright © Fiko Borizqy. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Fiko\AdminUrl\Plugin;

use Fiko\AdminUrl\Model\NotificationFactory;
use Magento\Backend\Model\Auth;
use Magento\Backend\Model\Url;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Authentication
{
    /**
     * Constructor
     *
     * @param Auth $auth
     * @param NotificationFactory $notificationFactory
     * @param ResultFactory $resultFactory
     * @param Url $url
     * @param ResponseInterface $response
     */
    public function __construct(
        Auth $auth,
        NotificationFactory $notificationFactory,
        ResultFactory $resultFactory,
        Url $url,
        ResponseInterface $response
    ) {
        $this->auth = $auth;
        $this->notificationFactory = $notificationFactory;
        $this->resultFactory = $resultFactory;
        $this->url = $url;
        $this->response = $response;
    }

    /**
     * Around method for dispatch method.
     *
     * @param \Magento\Backend\App\AbstractAction $subject
     * @param callable $proceed
     * @param \Magento\Framework\App\RequestInterface $request
     * @return void
     */
    public function aroundDispatch(
        \Magento\Backend\App\AbstractAction $subject,
        callable $proceed,
        \Magento\Framework\App\RequestInterface $request
    ) {
        if ($request->getParam('fiko_adminurl') === null) {
            return $proceed($request);
        }
        if ($request->getMethod() !== 'POST') {
            return $proceed($request);
        }
        if ($request->getActionName() !== 'index') {
            return $proceed($request);
        }
        if ($request->getControllerName() !== 'index') {
            return $proceed($request);
        }
        if (!$this->auth->isLoggedIn()) {
            return $proceed($request);
        }

        $notification = $this->notificationFactory->create()->load($request->getParam('fiko_adminurl'));
        if ($notification->isEmpty()) {
            return $proceed($request);
        }

        $this->response->setRedirect($this->url->getUrl($notification->getDestination()))->sendResponse();

        return false;
    }
}
