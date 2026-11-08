<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    public function devices()
    {
        return $this->hasMany(Device::class, 'current_warehouse_id');
    }

    protected $fillable = [
        'name',
        'location',
        'remarks',
    ];
}
