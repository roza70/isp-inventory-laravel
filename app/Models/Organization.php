<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'remarks',
    ];
    public function usageInfos(): HasMany
    {
        return $this->hasMany(UsageInfo::class);
    }
}
