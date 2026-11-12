<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warehouse_transfers', function (Blueprint $table) {
            $table->enum('approval_status', [
                'pending',
                'approved',
                'rejected',
            ])->default('pending');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->text('approval_remarks')->nullable();
        });

        Schema::table('stock_adjustments', function (Blueprint $table) {
            $table->enum('approval_status', [
                'pending',
                'approved',
                'rejected',
            ])->default('pending');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->text('approval_remarks')->nullable();
        });

        // Preserve existing transactions as approved.
        DB::table('warehouse_transfers')
            ->update(['approval_status' => 'approved']);

        DB::table('stock_adjustments')
            ->update(['approval_status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('warehouse_transfers', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);

            $table->dropColumn([
                'approval_status',
                'approved_by',
                'approved_at',
                'approval_remarks',
            ]);
        });

        Schema::table('stock_adjustments', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);

            $table->dropColumn([
                'approval_status',
                'approved_by',
                'approved_at',
                'approval_remarks',
            ]);
        });
    }
};
