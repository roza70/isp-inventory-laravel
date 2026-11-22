<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_device_status_cannot_be_changed_through_create_request(): void
    {
        $user = User::factory()->create();

        $product = Product::create([
            'model_name' => 'STATUS-TEST-ROUTER',
            'brand' => 'Test Brand',
            'type' => 'Router',
        ]);

        $response = $this->actingAs($user)->post(route('devices.store'), [
            'product_id' => $product->id,
            'serial_number' => 'STATUS-SPOOF-CREATE',
            'condition' => 'new',
            'status' => 'wasted',
        ]);

        $response->assertRedirect(route('devices.index'));

        $this->assertDatabaseHas('devices', [
            'serial_number' => 'STATUS-SPOOF-CREATE',
            'status' => 'in_stock',
        ]);
    }

    public function test_existing_device_status_cannot_be_changed_through_update_request(): void
    {
        $user = User::factory()->create();

        $product = Product::create([
            'model_name' => 'STATUS-TEST-ROUTER',
            'brand' => 'Test Brand',
            'type' => 'Router',
        ]);

        $device = Device::create([
            'product_id' => $product->id,
            'serial_number' => 'STATUS-SPOOF-UPDATE',
            'condition' => 'new',
            'status' => 'wasted',
        ]);

        $response = $this->actingAs($user)->put(
            route('devices.update', $device->id),
            [
                'product_id' => $product->id,
                'serial_number' => 'STATUS-SPOOF-UPDATE',
                'condition' => 'new',
                'status' => 'in_stock',
            ]
        );

        $response->assertRedirect(route('devices.index'));

        $this->assertDatabaseHas('devices', [
            'id' => $device->id,
            'status' => 'wasted',
        ]);
    }
}
