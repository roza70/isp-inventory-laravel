<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // This raw SQL is specific to MySQL.
        // SQLite already handles the enum update through
        // the previous Laravel Schema migration.
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("
            ALTER TABLE devices
            MODIFY status
            ENUM(
                'in_stock',
                'in_use',
                'faulty',
                'written_off',
                'wasted'
            )
            NOT NULL DEFAULT 'in_stock'
        ");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("
            ALTER TABLE devices
            MODIFY status
            ENUM(
                'in_stock',
                'in_use',
                'faulty',
                'written_off'
            )
            NOT NULL DEFAULT 'in_stock'
        ");
    }
};
