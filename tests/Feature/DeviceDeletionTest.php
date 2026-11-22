<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Device;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DeviceDeletionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A device with inventory history cannot be deleted.
     */
    public function test_device_with_usage_history_cannot_be_deleted(): void
    {
        $this->actingAs(
            User::factory()->create(['role' => 'staff'])
        );

        $product = Product::create([
            'model_name' => 'Delete Test Router',
            'brand' => 'Test Brand',
            'type' => 'Router',
        ]);

        $device = Device::create([
            'product_id' => $product->id,
            'serial_number' => 'DELETE-HISTORY-001',
            'condition' => 'new',
        ]);

        $organization = Organization::create([
            'name' => 'Delete Test Organization',
        ]);

        DB::table('usage_infos')->insert([
            'device_id' => $device->id,
            'organization_id' => $organization->id,
            'issue_date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->delete(
            route('devices.destroy', $device->id)
        );

        $response->assertRedirect(route('devices.index'));

        $response->assertSessionHas(
            'error',
            'This device cannot be deleted because it has related inventory history.'
        );

        $this->assertDatabaseHas('devices', [
            'id' => $device->id,
            'serial_number' => 'DELETE-HISTORY-001',
        ]);
    }

    /**
     * A device without inventory history can be deleted.
     */
    public function test_device_without_history_can_be_deleted(): void
    {
        $this->actingAs(
            User::factory()->create(['role' => 'staff'])
        );

        $product = Product::create([
            'model_name' => 'Delete Test Router',
            'brand' => 'Test Brand',
            'type' => 'Router',
        ]);

        $device = Device::create([
            'product_id' => $product->id,
            'serial_number' => 'DELETE-CLEAN-001',
            'condition' => 'new',
        ]);

        $response = $this->delete(
            route('devices.destroy', $device->id)
        );

        $response->assertRedirect(route('devices.index'));

        $response->assertSessionHas(
            'success',
            'Device deleted successfully!'
        );

        $this->assertDatabaseMissing('devices', [
            'id' => $device->id,
        ]);
    }
}
