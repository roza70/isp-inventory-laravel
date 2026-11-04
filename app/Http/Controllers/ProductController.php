<?php

namespace App\Http\Controllers;

class ProductController extends Controller
{
 public function index()
{
    $products = [
        [
            'name' => 'TP-Link Router',
            'brand' => 'TP-Link',
            'type' => 'Router'
        ],
        [
            'name' => 'Huawei ONU',
            'brand' => 'Huawei',
            'type' => 'ONU'
        ],
        [
            'name' => 'D-Link Switch',
            'brand' => 'D-Link',
            'type' => 'Network Switch'
        ],
        [
            'name' => 'ZTE ONU',
            'brand' => 'ZTE',
            'type' => 'ONU'
        ]
    ];

    return view('products.index', [
        'products' => $products
    ]);
}

}