<?php

namespace Fiko\AdminUrl\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    const TABLE_NAME = 'fiko_adminurl_notification';

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable(self::TABLE_NAME))
            ->addColumn(
                'key',
                Table::TYPE_TEXT,
                50,
                [
                    'nullable' => false,
                    'unsigned' => true,
                    'primary' => true
                ],
                'Notification key'
            )
            ->addColumn(
                'destination',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'URL Destination'
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT
                ],
                'Created At'
            )
            ->setComment('Adminhtml direct link');
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
