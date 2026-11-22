<?php

namespace App\Http\Controllers;

use App\Services\StockService;
use App\Models\UsageInfo;

class ReportsController extends Controller
{
    // Display Available Stock Report
    public function availableStock(StockService $stockService)
    {
        $stockSummary = $stockService->getAvailableStockSummary();

        $totalNew = $stockSummary->sum('new_quantity');

        $totalOld = $stockSummary->sum('old_quantity');

        $totalQuantity = $stockSummary->sum('total_quantity');

        return view('reports.available-stock', compact(
            'stockSummary',
            'totalNew',
            'totalOld',
            'totalQuantity'
        ));
    }

    // Display Usage Report
    public function usageReport()
    {
        // Get all usage records with related device, product and organization
        $usageInfos = UsageInfo::with([
            'device.product',
            'organization'
        ])->latest()->get();

        // Calculate usage totals
        $totalUsageRecords = $usageInfos->count();

        $currentlyInUse = $usageInfos
            ->whereNull('return_date')
            ->count();

        $returnedDevices = $usageInfos
            ->whereNotNull('return_date')
            ->count();

        return view('reports.usage', compact(
            'usageInfos',
            'totalUsageRecords',
            'currentlyInUse',
            'returnedDevices'
        ));
    }
}
