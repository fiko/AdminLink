<?php

namespace Fiko\AdminUrl\Model\ResourceModel\Notification;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use \Fiko\AdminUrl\Model\Notification;
use \Fiko\AdminUrl\Model\ResourceModel\Notification as ResourceModelNotification;

class Collection extends AbstractCollection
{
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
