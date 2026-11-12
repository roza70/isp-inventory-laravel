<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_adjustments', function (Blueprint $table) {

            $table->foreignId('product_id')
                ->nullable()
                ->after('device_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('serial_number')->nullable();

            $table->string('mac_address')->nullable();

            $table->enum('condition', [
                'new',
                'old',
            ])->nullable();

            $table->foreignId('current_warehouse_id')
                ->nullable()
                ->constrained('warehouses')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('stock_adjustments', function (Blueprint $table) {

            $table->dropForeign(['product_id']);
            $table->dropForeign(['current_warehouse_id']);

            $table->dropColumn([
                'product_id',
                'serial_number',
                'mac_address',
                'condition',
                'current_warehouse_id',
            ]);
        });
    }
};
