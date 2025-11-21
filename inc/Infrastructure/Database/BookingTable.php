<?php

namespace TravelBooking\Infrastructure\Database;

use Exception;

final class BookingTable extends BaseTable
{
    protected static ?self $instance = null;

    private function __construct()
    {
        parent::__construct();
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): self
    {
        return self::$instance ??= (self::$instance = new self());
    }

    protected static function ID_COLUMN_NAME(): string
    {
        return 'id';
    }
    protected static function TABLE_NAME(): string
    {
        return 'booking_data';
    }

    public function getSchema(): string
    {
        $table = $this->getTableName();
        $id_name = self::ID_COLUMN_NAME();
        $charset_collate = $this->getCharsetCollate();
        return "
        CREATE TABLE IF NOT EXISTS {$table} (
            booking_id        BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            
            booking_code      CHAR(36) NOT NULL UNIQUE DEFAULT (UUID()) COMMENT 'UUID v4',
            
            customer_id       BIGINT UNSIGNED NOT NULL,
            tour_name         VARCHAR(255) NOT NULL,
            start_date        DATE NOT NULL,
            total_persons     SMALLINT UNSIGNED NOT NULL DEFAULT 1,
            booking_date      DATE NOT NULL,
            
            note              TEXT NULL,
            
            booking_status    VARCHAR(30) NOT NULL DEFAULT 'pending',
            
            created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

        -- Ràng buộc toàn vẹn tham chiếu
        -- CONSTRAINT fk_booking_customer 
        --    FOREIGN KEY (customer_id) REFERENCES wp_users(ID) 
        --    ON DELETE RESTRICT ON UPDATE CASCADE,
    
        -- INDEX cực kỳ quan trọng
        INDEX idx_customer_status (customer_id, booking_status),
        INDEX idx_status_date (booking_status, start_date),
        INDEX idx_code (booking_code),
        INDEX idx_start_date (start_date),
        INDEX idx_created_at (created_at DESC)

        ) $charset_collate;";

    }

    public function updateRow(int $id, array $data): bool
    {
        $table = $this->getTableName();
        $updated = $this->wpdb->update(
            $table,
            $data,
            ['booking_id' => $id]
        );

        return (bool)$updated;
    }

    protected function validFormatData(): array{
        return [
            'customer_id',
            'tour_id',
            'scheduler_id',
            'taxonomy_tour_type_id',
            'taxonomy_tour_location_id',
            'taxonomy_tour_cost_id',
            'taxonomy_tour_linked_id',
            'taxonomy_tour_person_id',
            'taxonomy_tour_rating_id',
            'booking_status'
        ];
    }

}


