<?php

namespace App\Services;

use App\Models\Device;

class StockService
{
  // Calculate product-wise available stock
  public function getAvailableStockSummary()
  {
    return Device::with('product')
      ->where('status', 'in_stock')
      ->get()
      ->groupBy('product_id')
      ->map(function ($devices) {
        return [
          'product' => $devices->first()->product,

          'new_quantity' => $devices
            ->where('condition', 'new')
            ->count(),

          'old_quantity' => $devices
            ->where('condition', 'old')
            ->count(),

          'total_quantity' => $devices->count(),

          'remarks' => $devices
            ->pluck('remarks')
            ->filter()
            ->unique()
            ->values()
            ->implode('; '),
        ];
      })
      ->values();
  }
}
