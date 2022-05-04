<?php

/**
 * Copyright © Fiko Borizqy. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Fiko\AdminUrl\Model;

use Fiko\AdminUrl\Model\ResourceModel\Notification;
use Magento\Backend\Model\Url as MagentoUrl;

class Url
{
    /**
     * Constructor.
     *
     * @param NotificationFactory $notificationFactory
     * @param Notification $notificationResourceModel
     * @param MagentoUrl $url
     */
    public function __construct(
        NotificationFactory $notificationFactory,
        Notification $notificationResourceModel,
        MagentoUrl $url
    ) {
        $this->notificationFactory = $notificationFactory;
        $this->notificationResourceModel = $notificationResourceModel;
        $this->url = $url;
    }

    /**
     * Generating key for the record.
     *
     * @return string
     */
    public function generateKey()
    {
        return hash('tiger192,3', uniqid().time().uniqid());
    }

    /**
     * Getting url from specific path.
     *
     * @param string $path
     * @param array $params
     * @return void
     */
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

        return $this->url->getUrl('fiko_adminurl/go/to', ['key' => $key]).$path;
    }
}
