<?php

namespace App\Http\Controllers;

class HelloIspController extends Controller
{
    public function index()
    {
        $companyName = "ABC Internet Service Provider";

        $systemName = "ISP Inventory Management System";

        $totalProducts = 25;

        $systemStatus = "Under Development";

        $isSystemActive = true;
        $products = [
    "Router",
    "ONU",
    "Fiber Optic Cable",
    "Network Switch",
    "LAN Cable"
];

        return view('hello-isp', [
            'companyName' => $companyName,
            'systemName' => $systemName,
            'totalProducts' => $totalProducts,
            'systemStatus' => $systemStatus,
            'isSystemActive' => $isSystemActive,
            'products' => $products
        ]);
    }
}