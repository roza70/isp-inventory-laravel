<?php

namespace App\Http\Controllers;

class HelloIspController extends Controller
{
    public function index()
    {
        $productName = "TP-Link Router";
        $brand = "TP-Link";
        $type = "Router";

        return view('products.index', [
            'productName' => $productName,
            'brand' => $brand,
            'type' => $type
        ]);
    }
}
