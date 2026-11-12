<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('warehouse_transfers', function (Blueprint $table) {

            $table->foreignId('device_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('from_warehouse_id')
                ->references('id')
                ->on('warehouses')
                ->restrictOnDelete();

            $table->foreignId('to_warehouse_id')
                ->references('id')
                ->on('warehouses')
                ->restrictOnDelete();

            $table->date('transfer_date');

            $table->text('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warehouse_transfers', function (Blueprint $table) {

            $table->dropForeign(['device_id']);
            $table->dropForeign(['from_warehouse_id']);
            $table->dropForeign(['to_warehouse_id']);

            $table->dropColumn([
                'device_id',
                'from_warehouse_id',
                'to_warehouse_id',
                'transfer_date',
                'remarks',
            ]);
        });
    }
};
