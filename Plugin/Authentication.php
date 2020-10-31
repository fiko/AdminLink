<?php

namespace Fiko\AdminUrl\Plugin;

use Magento\Backend\Model\Auth;
use Fiko\AdminUrl\Model\NotificationFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\Model\Url;
use Magento\Framework\App\ResponseInterface;

class Authentication
{
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

    public function aroundDispatch(
        \Magento\Backend\App\AbstractAction $subject,
        callable $proceed,
        \Magento\Framework\App\RequestInterface $request
    ) {
        if (is_null($request->getParam('fiko_adminurl'))) return $proceed($request);
        if ($request->getMethod() !== "POST") return $proceed($request);
        if ($request->getActionName() !== "index") return $proceed($request);
        if ($request->getControllerName() !== "index") return $proceed($request);
        if (!$this->auth->isLoggedIn()) return $proceed($request);

        $notification = $this->notificationFactory->create()->load($request->getParam('fiko_adminurl'));
        if ($notification->isEmpty()) return $proceed($request);

        $this->response->setRedirect($this->url->getUrl($notification->getDestination()))->sendResponse();
        return false;
    }
}
