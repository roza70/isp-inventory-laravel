<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Available Stock Report
    </h2>
  </x-slot>

  <div class="py-8 report-page">
    <div class="max-w-7xl mx-auto sm:px-6 sm:px-8">
      <div class="bg-white p-6 shadow-sm sm:rounded-lg report-container">

        {{-- Report Header --}}
        <div class="text-center mb-6 report-header">
          <h1 class="text-2xl font-bold">
            ISP Inventory Management System
          </h1>

          <h2 class="text-xl font-semibold mt-2">
            Available Stock Report
          </h2>

          <p class="mt-2">
            Report Date: {{ now()->format('d-m-Y') }}
          </p>
        </div>

        {{-- Print Button --}}
        <div class="mb-6 text-right print-controls">
          <button type="button"
            onclick="window.print()"
            style="background-color:#2563eb;color:white;padding:10px 18px;border-radius:6px;border:none;cursor:pointer;">
            Print Report
          </button>
        </div>

        {{-- Stock Table --}}
        <div class="overflow-x-auto report-table-wrapper">
          <table class="w-full border-collapse border border-gray-400 report-table">
            <thead>
              <tr class="bg-gray-200">
                <th class="border border-gray-400 px-3 py-2 text-left">SL</th>
                <th class="border border-gray-400 px-3 py-2 text-left">Model Name</th>
                <th class="border border-gray-400 px-3 py-2 text-center">New Quantity</th>
                <th class="border border-gray-400 px-3 py-2 text-center">Old Quantity</th>
                <th class="border border-gray-400 px-3 py-2 text-center">Total Quantity</th>
                <th class="border border-gray-400 px-3 py-2 text-left">Remarks</th>
              </tr>
            </thead>

            <tbody>
              @forelse ($stockSummary as $index => $summary)
              <tr>
                <td class="border border-gray-400 px-3 py-2">
                  {{ $index + 1 }}
                </td>

                <td class="border border-gray-400 px-3 py-2">
                  {{ $summary['product']->model_name }}
                </td>

                <td class="border border-gray-400 px-3 py-2 text-center">
                  {{ $summary['new_quantity'] }}
                </td>

                <td class="border border-gray-400 px-3 py-2 text-center">
                  {{ $summary['old_quantity'] }}
                </td>

                <td class="border border-gray-400 px-3 py-2 text-center">
                  {{ $summary['total_quantity'] }}
                </td>

                <td class="border border-gray-400 px-3 py-2">
                  {{ $summary['remarks'] ?: '-' }}
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="border border-gray-400 px-4 py-6 text-center">
                  No available stock found.
                </td>
              </tr>
              @endforelse
            </tbody>

            <tfoot>
              <tr class="bg-gray-200 font-bold">
                <td colspan="2" class="border border-gray-400 px-3 py-2 text-right">
                  Grand Total
                </td>

                <td class="border border-gray-400 px-3 py-2 text-center">
                  {{ $totalNew }}
                </td>

                <td class="border border-gray-400 px-3 py-2 text-center">
                  {{ $totalOld }}
                </td>

                <td class="border border-gray-400 px-3 py-2 text-center">
                  {{ $totalQuantity }}
                </td>

                <td class="border border-gray-400 px-3 py-2">
                  -
                </td>
              </tr>
            </tfoot>
          </table>
        </div>

        {{-- Signature Section --}}
        <div class="grid grid-cols-2 gap-10 mt-16 text-center signature-section">
          <div class="signature-box">
            <div class="signature-line">Prepared By</div>
          </div>

          <div class="signature-box">
            <div class="signature-line">Checked By</div>
          </div>

          <div class="signature-box">
            <div class="signature-line">Recommended By</div>
          </div>

          <div class="signature-box">
            <div class="signature-line">Approved By</div>
          </div>
        </div>

      </div>
    </div>
  </div>

  {{-- Print Styling --}}
  <style>
    @media print {

      @page {
        size: A4 portrait;
        margin: 15mm;
      }

      body {
        background: white !important;
        font-size: 12px !important;
      }

      nav {
        display: none !important;
      }

      .print-controls {
        display: none !important;
      }

      .report-page {
        padding: 0 !important;
      }

      .report-container {
        max-width: 100% !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
        box-shadow: none !important;
        border: none !important;
      }

      .report-header {
        margin-bottom: 25px !important;
      }

      .report-table-wrapper {
        overflow: visible !important;
      }

      .report-table {
        width: 100% !important;
        border-collapse: collapse !important;
      }

      .report-table th,
      .report-table td {
        border: 1px solid black !important;
        padding: 8px !important;
        font-size: 10px !important;
        color: black !important;
      }

      .report-table th {
        background: #e5e5e5 !important;
      }

      .signature-section {
        margin-top: 65px !important;
        gap: 55px 45px !important;
      }

      .signature-box {
        height: 85px !important;
        display: flex !important;
        align-items: flex-end !important;
        justify-content: center !important;
      }

      .signature-line {
        width: 75% !important;
        border-top: 1px solid black !important;
        padding-top: 7px !important;
        font-size: 11px !important;
      }
    }
  </style>
</x-app-layout>