<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsageInfo extends Model
{
    protected $fillable = [
        'device_id',
        'organization_id',
        'issue_date',
        'return_date',
        'remarks',
    ];

    // Convert database date strings into Carbon date objects
    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'return_date' => 'date',
        ];
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
