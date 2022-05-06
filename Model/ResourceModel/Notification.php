<?php

/**
 * Copyright © Fiko Borizqy. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Fiko\AdminUrl\Model\ResourceModel;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Psr\Log\LoggerInterface;

class Notification extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public const MAIN_TABLE_NAME = 'fiko_adminurl_notification';

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor
     *
     * @param Context $context
     * @param ResourceConnection $resourceConnection
     * @param LoggerInterface $logger
     * @param string|null $connectionName
     */
    public function __construct(
        Context $context,
        ResourceConnection $resourceConnection,
        LoggerInterface $logger,
        $connectionName = null
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->logger = $logger;

        parent::__construct($context, $connectionName);
    }

    /**
     * Initiate main table construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE_NAME, 'key');
    }

    /**
     * Method to save to table.
     *
     * @param \Fiko\AdminUrl\Model\Notification $notification
     * @return void
     */
    public function save($notification)
    {
        try {
            $this->resourceConnection->getConnection()->query(
                "INSERT INTO fiko_adminurl_notification VALUES (:key, :destination, NOW()) 
                ON DUPLICATE KEY UPDATE destination = :destination",
                [
                    ':key' => $notification->getKey(),
                    ':destination' => $notification->getDestination(),
                ]
            );
        } catch (\Exception $e) {
            $this->logger->warning($e->getMessage(), ['exception' => $e]);
        }
    }
}
