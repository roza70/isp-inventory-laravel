<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->enum('status', [
                'in_stock',
                'in_use',
                'faulty',
                'written_off',
                'wasted',
            ])->default('in_stock')->change();
        });
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->enum('status', [
                'in_stock',
                'in_use',
                'faulty',
                'written_off',
            ])->default('in_stock')->change();
        });
    }
};
