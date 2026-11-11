<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Device;

class FaultyDevice extends Model
{
    protected $fillable = [
        'device_id',
        'fault_date',
        'fault_description',
        'resolution_status',
        'remarks',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
