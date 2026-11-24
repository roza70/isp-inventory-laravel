<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Product;
use App\Models\StockAdjustment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockAdjustmentApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_increase_stock_adjustment(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $product = Product::create([
            'model_name' => 'APPROVAL-TEST-ROUTER',
            'brand' => 'Test Brand',
            'type' => 'Router',
        ]);

        $adjustment = StockAdjustment::create([
            'device_id' => null,
            'product_id' => $product->id,
            'serial_number' => 'APPROVAL-TEST-001',
            'mac_address' => null,
            'condition' => 'new',
            'current_warehouse_id' => null,
            'adjustment_type' => 'increase',
            'adjustment_date' => now()->toDateString(),
            'reason' => 'New router received',
            'remarks' => 'Approval test',
            'approval_status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(
            route('stock-adjustments.approve', $adjustment),
            ['approval_remarks' => 'Approved by admin']
        );

        $response->assertRedirect(route('stock-adjustments.index'));

        $response->assertSessionHas(
            'success',
            'Stock adjustment approved successfully!'
        );

        $this->assertDatabaseHas('devices', [
            'product_id' => $product->id,
            'serial_number' => 'APPROVAL-TEST-001',
            'status' => 'in_stock',
        ]);

        $adjustment->refresh();

        $this->assertSame('approved', $adjustment->approval_status);
        $this->assertSame($admin->id, $adjustment->approved_by);
        $this->assertNotNull($adjustment->approved_at);
        $this->assertNotNull($adjustment->device_id);
        $this->assertSame(
            'Approved by admin',
            $adjustment->approval_remarks
        );
    }

    public function test_admin_can_approve_decrease_stock_adjustment(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $product = Product::create([
            'model_name' => 'DECREASE-TEST-ROUTER',
            'brand' => 'Test Brand',
            'type' => 'Router',
        ]);

        $device = Device::create([
            'product_id' => $product->id,
            'serial_number' => 'DECREASE-TEST-001',
            'mac_address' => null,
            'condition' => 'new',
            'status' => 'in_stock',
            'current_warehouse_id' => null,
            'remarks' => 'Decrease approval test',
        ]);

        $adjustment = StockAdjustment::create([
            'device_id' => $device->id,
            'product_id' => null,
            'adjustment_type' => 'decrease',
            'adjustment_date' => now()->toDateString(),
            'reason' => 'Device written off',
            'approval_status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(
            route('stock-adjustments.approve', $adjustment),
            ['approval_remarks' => 'Approved for write-off']
        );

        $response->assertRedirect(route('stock-adjustments.index'));

        $this->assertDatabaseHas('devices', [
            'id' => $device->id,
            'status' => 'written_off',
        ]);

        $adjustment->refresh();

        $this->assertSame('approved', $adjustment->approval_status);
        $this->assertSame($admin->id, $adjustment->approved_by);
        $this->assertNotNull($adjustment->approved_at);
    }

    public function test_staff_cannot_approve_stock_adjustment(): void
    {
        $staff = User::factory()->create();

        $product = Product::create([
            'model_name' => 'STAFF-TEST-ROUTER',
            'brand' => 'Test Brand',
            'type' => 'Router',
        ]);

        $adjustment = StockAdjustment::create([
            'device_id' => null,
            'product_id' => $product->id,
            'serial_number' => 'STAFF-TEST-001',
            'mac_address' => null,
            'condition' => 'new',
            'current_warehouse_id' => null,
            'adjustment_type' => 'increase',
            'adjustment_date' => now()->toDateString(),
            'reason' => 'New router received',
            'approval_status' => 'pending',
        ]);

        $response = $this->actingAs($staff)->post(
            route('stock-adjustments.approve', $adjustment),
            ['approval_remarks' => 'Trying to approve']
        );

        $response->assertForbidden();

        $this->assertDatabaseHas('stock_adjustments', [
            'id' => $adjustment->id,
            'approval_status' => 'pending',
        ]);

        $this->assertDatabaseMissing('devices', [
            'serial_number' => 'STAFF-TEST-001',
        ]);
    }

    public function test_admin_cannot_approve_same_adjustment_twice(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $product = Product::create([
            'model_name' => 'DUPLICATE-TEST-ROUTER',
            'brand' => 'Test Brand',
            'type' => 'Router',
        ]);

        $adjustment = StockAdjustment::create([
            'device_id' => null,
            'product_id' => $product->id,
            'serial_number' => 'DUPLICATE-TEST-001',
            'mac_address' => null,
            'condition' => 'new',
            'current_warehouse_id' => null,
            'adjustment_type' => 'increase',
            'adjustment_date' => now()->toDateString(),
            'reason' => 'New router received',
            'approval_status' => 'pending',
        ]);

        $firstResponse = $this->actingAs($admin)->post(
            route('stock-adjustments.approve', $adjustment),
            ['approval_remarks' => 'First approval']
        );

        $firstResponse->assertRedirect(route('stock-adjustments.index'));

        $secondResponse = $this->from(
            route('stock-adjustments.index')
        )->post(
            route('stock-adjustments.approve', $adjustment),
            ['approval_remarks' => 'Second approval attempt']
        );

        $secondResponse->assertRedirect(route('stock-adjustments.index'));
        $secondResponse->assertSessionHasErrors('approval_status');

        $this->assertSame(
            1,
            Device::where(
                'serial_number',
                'DUPLICATE-TEST-001'
            )->count()
        );

        $adjustment->refresh();

        $this->assertSame('approved', $adjustment->approval_status);
        $this->assertSame(
            'First approval',
            $adjustment->approval_remarks
        );
    }

    public function test_admin_can_reject_stock_adjustment(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $product = Product::create([
            'model_name' => 'REJECT-TEST-ROUTER',
            'brand' => 'Test Brand',
            'type' => 'Router',
        ]);

        $adjustment = StockAdjustment::create([
            'device_id' => null,
            'product_id' => $product->id,
            'serial_number' => 'REJECT-TEST-001',
            'mac_address' => null,
            'condition' => 'new',
            'current_warehouse_id' => null,
            'adjustment_type' => 'increase',
            'adjustment_date' => now()->toDateString(),
            'reason' => 'New router received',
            'approval_status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(
            route('stock-adjustments.reject', $adjustment),
            ['approval_remarks' => 'Rejected by admin']
        );

        $response->assertRedirect(route('stock-adjustments.index'));

        $adjustment->refresh();

        $this->assertSame('rejected', $adjustment->approval_status);
        $this->assertSame($admin->id, $adjustment->approved_by);
        $this->assertNotNull($adjustment->approved_at);
        $this->assertSame(
            'Rejected by admin',
            $adjustment->approval_remarks
        );

        $this->assertDatabaseMissing('devices', [
            'serial_number' => 'REJECT-TEST-001',
        ]);
    }

    public function test_staff_cannot_reject_stock_adjustment(): void
    {
        $staff = User::factory()->create();

        $product = Product::create([
            'model_name' => 'STAFF-REJECT-ROUTER',
            'brand' => 'Test Brand',
            'type' => 'Router',
        ]);

        $adjustment = StockAdjustment::create([
            'device_id' => null,
            'product_id' => $product->id,
            'serial_number' => 'STAFF-REJECT-001',
            'mac_address' => null,
            'condition' => 'new',
            'current_warehouse_id' => null,
            'adjustment_type' => 'increase',
            'adjustment_date' => now()->toDateString(),
            'reason' => 'New router received',
            'approval_status' => 'pending',
        ]);

        $response = $this->actingAs($staff)->post(
            route('stock-adjustments.reject', $adjustment),
            ['approval_remarks' => 'Trying to reject']
        );

        $response->assertForbidden();

        $this->assertDatabaseHas('stock_adjustments', [
            'id' => $adjustment->id,
            'approval_status' => 'pending',
        ]);
    }

    public function test_admin_cannot_reject_same_adjustment_twice(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $product = Product::create([
            'model_name' => 'DUPLICATE-REJECT-ROUTER',
            'brand' => 'Test Brand',
            'type' => 'Router',
        ]);

        $adjustment = StockAdjustment::create([
            'device_id' => null,
            'product_id' => $product->id,
            'serial_number' => 'DUPLICATE-REJECT-001',
            'mac_address' => null,
            'condition' => 'new',
            'current_warehouse_id' => null,
            'adjustment_type' => 'increase',
            'adjustment_date' => now()->toDateString(),
            'reason' => 'New router received',
            'approval_status' => 'pending',
        ]);

        $firstResponse = $this->actingAs($admin)->post(
            route('stock-adjustments.reject', $adjustment),
            ['approval_remarks' => 'First rejection']
        );

        $firstResponse->assertRedirect(route('stock-adjustments.index'));

        $secondResponse = $this->from(
            route('stock-adjustments.index')
        )->post(
            route('stock-adjustments.reject', $adjustment),
            ['approval_remarks' => 'Second rejection attempt']
        );

        $secondResponse->assertRedirect(route('stock-adjustments.index'));
        $secondResponse->assertSessionHasErrors('approval_status');

        $adjustment->refresh();

        $this->assertSame('rejected', $adjustment->approval_status);
        $this->assertSame(
            'First rejection',
            $adjustment->approval_remarks
        );
    }
}
