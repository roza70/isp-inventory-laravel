<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wastage extends Model
{
    protected $fillable = [
        'device_id',
        'wastage_date',
        'reason',
        'remarks',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
