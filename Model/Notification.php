<?php

namespace Fiko\AdminUrl\Model;

use \Magento\Framework\Model\Context;
use \Magento\Framework\Registry;
use \Magento\Framework\Model\ResourceModel\AbstractResource;
use \Magento\Framework\Data\Collection\AbstractDb;
use \Magento\Framework\Model\AbstractModel;
use \Fiko\AdminUrl\Api\Data\NotificationInterface;
use \Fiko\AdminUrl\Model\ResourceModel\Notification as ResourceModelNotification;

class Notification extends AbstractModel implements NotificationInterface
{
    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModelNotification::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return $this->getData(self::KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function setKey($key)
    {
        $this->setData(self::KEY, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getDestination()
    {
        return $this->getData(self::DESTINATION);
    }

    /**
     * {@inheritdoc}
     */
    public function setDestination($destination)
    {
        $this->setData(self::DESTINATION, $destination);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($createdAt)
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }
}
