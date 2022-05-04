<?php

/**
 * Copyright © Fiko Borizqy. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Fiko\AdminUrl\Model;

use Fiko\AdminUrl\Api\Data\NotificationInterface;
use Fiko\AdminUrl\Model\ResourceModel\Notification as ResourceModelNotification;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Notification extends AbstractModel implements NotificationInterface
{
    // /**
    //  * Constructor
    //  *
    //  * @param Context $context
    //  * @param Registry $registry
    //  * @param AbstractResource|null $resource
    //  * @param AbstractDb|null $resourceCollection
    //  * @param array $data
    //  */
    // public function __construct(
    //     Context $context,
    //     Registry $registry,
    //     AbstractResource $resource = null,
    //     AbstractDb $resourceCollection = null,
    //     array $data = []
    // ) {
    //     parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    // }

    /**
     * Initialize resource model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModelNotification::class);
    }

    /**
     * {{@inheritdoc}}
     */
    public function getKey()
    {
        return $this->getData(self::KEY);
    }

    /**
     * Setup key of the row.
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->setData(self::KEY, $key);
    }

    /**
     * {{@inheritdoc}}
     */
    public function getDestination()
    {
        return $this->getData(self::DESTINATION);
    }

    /**
     * Setup destination.
     *
     * @param string $destination
     */
    public function setDestination($destination)
    {
        $this->setData(self::DESTINATION, $destination);
    }

    /**
     * {{@inheritdoc}}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set timestamp of when it's created.
     *
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }
}
