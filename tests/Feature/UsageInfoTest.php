<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Organization;
use App\Models\Product;
use App\Models\User;
use App\Models\UsageInfo;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsageInfoTest extends TestCase
{
    use RefreshDatabase;

    private function createInventoryData(): array
    {
        $product = Product::create([
            'model_name' => 'USAGE-TEST-ROUTER',
            'brand' => 'Test Brand',
            'type' => 'Router',
        ]);

        $organization = Organization::create([
            'name' => 'Usage Test Branch',
            'address' => 'Dhaka',
        ]);

        $warehouse = Warehouse::create([
            'name' => 'Usage Test Warehouse',
            'location' => 'Dhaka',
        ]);

        $device = Device::create([
            'product_id' => $product->id,
            'serial_number' => 'USAGE-TEST-001',
            'condition' => 'new',
            'status' => 'in_stock',
            'current_warehouse_id' => $warehouse->id,
        ]);

        return compact('product', 'organization', 'warehouse', 'device');
    }

    public function test_user_can_issue_an_in_stock_device(): void
    {
        $user = User::factory()->create();
        $data = $this->createInventoryData();

        $response = $this->actingAs($user)->post(
            route('usage-infos.store'),
            [
                'device_id' => $data['device']->id,
                'organization_id' => $data['organization']->id,
                'issue_date' => '2026-11-24',
                'remarks' => 'Issued for testing',
            ]
        );

        $response->assertRedirect(route('devices.index'));

        $this->assertDatabaseHas('usage_infos', [
            'device_id' => $data['device']->id,
            'organization_id' => $data['organization']->id,
            'issue_date' => '2026-11-24 00:00:00',
            'return_date' => null,
        ]);

        $this->assertDatabaseHas('devices', [
            'id' => $data['device']->id,
            'status' => 'in_use',
            'current_warehouse_id' => null,
        ]);
    }

    public function test_user_cannot_issue_a_device_that_is_not_in_stock(): void
    {
        $user = User::factory()->create();
        $data = $this->createInventoryData();

        $data['device']->update([
            'status' => 'in_use',
            'current_warehouse_id' => null,
        ]);

        $response = $this->actingAs($user)->post(
            route('usage-infos.store'),
            [
                'device_id' => $data['device']->id,
                'organization_id' => $data['organization']->id,
                'issue_date' => '2026-11-24',
            ]
        );

        $response->assertSessionHasErrors('device_id');

        $this->assertDatabaseCount('usage_infos', 0);
    }

    public function test_user_can_return_an_issued_device_to_a_warehouse(): void
    {
        $user = User::factory()->create();
        $data = $this->createInventoryData();

        $data['device']->update([
            'status' => 'in_use',
            'current_warehouse_id' => null,
        ]);

        $usageInfo = UsageInfo::create([
            'device_id' => $data['device']->id,
            'organization_id' => $data['organization']->id,
            'issue_date' => '2026-11-20',
        ]);

        $response = $this->actingAs($user)->put(
            route('usage-infos.return', $usageInfo->id),
            [
                'warehouse_id' => $data['warehouse']->id,
            ]
        );

        $response->assertRedirect(route('usage-infos.index'));

        $this->assertDatabaseHas('usage_infos', [
            'id' => $usageInfo->id,
            'return_date' => now()->toDateString() . ' 00:00:00',
        ]);

        $this->assertDatabaseHas('devices', [
            'id' => $data['device']->id,
            'status' => 'in_stock',
            'current_warehouse_id' => $data['warehouse']->id,
        ]);
    }

    public function test_user_cannot_return_the_same_device_twice(): void
    {
        $user = User::factory()->create();
        $data = $this->createInventoryData();

        $data['device']->update([
            'status' => 'in_stock',
            'current_warehouse_id' => $data['warehouse']->id,
        ]);

        $usageInfo = UsageInfo::create([
            'device_id' => $data['device']->id,
            'organization_id' => $data['organization']->id,
            'issue_date' => '2026-11-20',
            'return_date' => '2026-11-23',
        ]);

        $response = $this->actingAs($user)->put(
            route('usage-infos.return', $usageInfo->id),
            [
                'warehouse_id' => $data['warehouse']->id,
            ]
        );

        $response->assertStatus(422);

        $this->assertDatabaseHas('usage_infos', [
            'id' => $usageInfo->id,
            'return_date' => '2026-11-23 00:00:00',
        ]);
    }
}
