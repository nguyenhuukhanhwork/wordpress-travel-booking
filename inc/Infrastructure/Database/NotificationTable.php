<?php

namespace TravelBooking\Infrastructure\Database;

use TravelBooking\Infrastructure\Notification\BaseNotification;

final class NotificationTable extends BaseTable
{
    public static ?self $instance = null;
    public static function getInstance(): self
    {
        return self::$instance ?? (self::$instance = new self());
    }
    private function __clone(){}
    public function __wakeup(){}
    protected static function TABLE_NAME(): string
    {
        return 'notifications';
    }
    protected static function ID_COLUMN_NAME(): string
    {
        return 'id';
    }
    protected function validFormatData(): array
    {
        return [
            'notification_type',
            'notification_message',
            'notification_status',
            'notification_error_log'
        ];
    }

    public function getSchema(): string
    {
        $table = $this->getTableName();
        $id_name = self::ID_COLUMN_NAME();
        $charset_collate = $this->getCharsetCollate();
        return "
        CREATE TABLE IF NOT EXISTS $table (
            -- id
            $id_name INT AUTO_INCREMENT PRIMARY KEY,
            
            -- main data
            kind VARCHAR(127) NOT NULL,
            message TEXT NOT NULL,
            status VARCHAR(20) NOT NULL DEFAULT 'error',
            error TEXT DEFAULT NULL,
            
            -- date
            sent_date TIMESTAMP,
            create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) $charset_collate;";
    }


    public function updateRow(int $id, array $data): bool
    {
       $table = $this->getTableName();
       return (bool) $this->wpdb->update($table, $data,[
           self::ID_COLUMN_NAME() => $id
       ]);
    }
}