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
        Schema::create('faulty_devices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('device_id')
                ->constrained()
                ->restrictOnDelete();

            $table->date('fault_date');

            $table->text('fault_description');

            $table->enum('resolution_status', [
                'pending',
                'under_repair',
                'repaired',
                'written_off'
            ])->default('pending');

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faulty_devices');
    }
};
