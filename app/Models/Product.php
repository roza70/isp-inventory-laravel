<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    protected $fillable = [
        'model_name',
        'brand',
        'type'
    ];
}
