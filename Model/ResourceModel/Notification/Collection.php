<?php

/**
 * Copyright © Fiko Borizqy. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Fiko\AdminUrl\Model\ResourceModel\Notification;

use Fiko\AdminUrl\Model\Notification;
use Fiko\AdminUrl\Model\ResourceModel\Notification as ResourceModelNotification;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'key';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Notification::class, ResourceModelNotification::class);
    }
}
