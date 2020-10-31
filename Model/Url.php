<?php

namespace Fiko\AdminUrl\Model;

use Fiko\AdminUrl\Model\NotificationFactory;
use Fiko\AdminUrl\Model\ResourceModel\Notification;
use Magento\Backend\Model\Url as MagentoUrl;

class Url
{
    public function __construct(
        NotificationFactory $notificationFactory,
        Notification $notificationResourceModel,
        MagentoUrl $url
    ) {
        $this->notificationFactory = $notificationFactory;
        $this->notificationResourceModel = $notificationResourceModel;
        $this->url = $url;
    }

    public function generateKey()
    {
        return hash('tiger192,3', uniqid() . time() . uniqid());
    }

    public function getUrl($path, $params = [])
    {
        $path .= substr($path, -1, 1) != '/' ? '/' : '';
        foreach ($params as $key => $value) {
            $path .= "{$key}/{$value}/";
        }
        $key = $this->generateKey();
        $notification = $this->notificationFactory->create();
        $notification->setKey($key);
        $notification->setDestination($path);
        $this->notificationResourceModel->save($notification);
        return $this->url->getUrl("fiko_adminurl/go/to", ['key' => $key]) . $path;
    }
}
