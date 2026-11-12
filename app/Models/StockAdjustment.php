<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockAdjustment extends Model
{
    protected $fillable = [
        'device_id',
        'product_id',
        'serial_number',
        'mac_address',
        'condition',
        'current_warehouse_id',
        'adjustment_type',
        'adjustment_date',
        'reason',
        'remarks',
        'approval_status',
        'approved_by',
        'approved_at',
        'approval_remarks',
    ];

    protected $casts = [
        'adjustment_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(
            Warehouse::class,
            'current_warehouse_id'
        );
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
