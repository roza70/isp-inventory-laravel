<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
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
