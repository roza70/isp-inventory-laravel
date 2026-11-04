<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        echo "ProductSeeder is running!\n";

        Product::create([
            'model_name' => 'Archer C6',
            'brand' => 'TP-Link',
            'type' => 'Router'
        ]);

        Product::create([
            'model_name' => 'HG8245H',
            'brand' => 'Huawei',
            'type' => 'ONU'
        ]);

        Product::create([
            'model_name' => 'DIR-825',
            'brand' => 'D-Link',
            'type' => 'Router'
        ]);

        Product::create([
            'model_name' => 'F670L',
            'brand' => 'ZTE',
            'type' => 'ONU'
        ]);

        Product::create([
            'model_name' => 'TL-SG1024',
            'brand' => 'TP-Link',
            'type' => 'Network Switch'
        ]);

        echo "Five products inserted successfully!\n";
    }
}
