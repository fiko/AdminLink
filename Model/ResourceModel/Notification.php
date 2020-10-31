<?php

namespace Fiko\AdminUrl\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface;

class Notification extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    const MAIN_TABLE_NAME = 'fiko_adminurl_notification';

    /**
     * @param \Magento\Framework\App\ResourceConnection
     */
    private $resourceConnection;

    /**
     * @param \Psr\Log\LoggerInterface
     */
    private $logger;

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

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE_NAME, 'key');
    }

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
