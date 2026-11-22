<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Usage Report
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
            Device Usage Report
          </h2>

          <p class="mt-2">
            Report Date: {{ now()->format('d-m-Y') }}
          </p>
        </div>

        {{-- Summary --}}
        <div class="grid grid-cols-3 gap-4 mb-6 report-summary">
          <div class="border p-4 text-center summary-box">
            <h3 class="font-semibold">Total Usage Records</h3>
            <p class="text-2xl font-bold mt-2">
              {{ $totalUsageRecords }}
            </p>
          </div>

          <div class="border p-4 text-center summary-box">
            <h3 class="font-semibold">Currently In Use</h3>
            <p class="text-2xl font-bold mt-2">
              {{ $currentlyInUse }}
            </p>
          </div>

          <div class="border p-4 text-center summary-box">
            <h3 class="font-semibold">Returned Devices</h3>
            <p class="text-2xl font-bold mt-2">
              {{ $returnedDevices }}
            </p>
          </div>
        </div>

        {{-- Print Button --}}
        <div class="mb-6 text-right print:hidden">
          <button onclick="window.print()"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Print Report
          </button>
        </div>

        {{-- Usage Records --}}
        <div class="overflow-x-auto report-table-wrapper">
          <table class="w-full border-collapse border border-gray-400 report-table">
            <thead>
              <tr class="bg-gray-200">
                <th class="border border-gray-400 px-3 py-2">SL</th>
                <th class="border border-gray-400 px-3 py-2">Model</th>
                <th class="border border-gray-400 px-3 py-2">Serial Number</th>
                <th class="border border-gray-400 px-3 py-2">MAC Address</th>
                <th class="border border-gray-400 px-3 py-2">Organization</th>
                <th class="border border-gray-400 px-3 py-2">Issue Date</th>
                <th class="border border-gray-400 px-3 py-2">Return Date</th>
                <th class="border border-gray-400 px-3 py-2">Status</th>
                <th class="border border-gray-400 px-3 py-2">Remarks</th>
              </tr>
            </thead>

            <tbody>
              @forelse ($usageInfos as $index => $usage)
              <tr>
                <td class="border border-gray-400 px-3 py-2">
                  {{ $index + 1 }}
                </td>

                <td class="border border-gray-400 px-3 py-2">
                  {{ $usage->device->product->model_name ?? 'N/A' }}
                </td>

                <td class="border border-gray-400 px-3 py-2">
                  {{ $usage->device->serial_number ?? 'N/A' }}
                </td>

                <td class="border border-gray-400 px-3 py-2">
                  {{ $usage->device->mac_address ?? 'N/A' }}
                </td>

                <td class="border border-gray-400 px-3 py-2">
                  {{ $usage->organization->name ?? 'N/A' }}
                </td>

                <td class="border border-gray-400 px-3 py-2">
                  {{ $usage->issue_date?->format('d-m-Y') ?? 'N/A' }}
                </td>

                <td class="border border-gray-400 px-3 py-2">
                  {{ $usage->return_date?->format('d-m-Y') ?? 'Not Returned' }}
                </td>

                <td class="border border-gray-400 px-3 py-2">
                  {{ $usage->return_date ? 'Returned' : 'In Use' }}
                </td>

                <td class="border border-gray-400 px-3 py-2">
                  {{ $usage->remarks ?? '-' }}
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="9"
                  class="border border-gray-400 px-4 py-6 text-center">
                  No usage records found.
                </td>
              </tr>
              @endforelse
            </tbody>
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

  {{-- Print CSS --}}
  <style>
    @media print {

      @page {
        size: A4 landscape;
        margin: 10mm;
      }

      body {
        background: white !important;
        font-size: 10px !important;
      }

      /* Hide Laravel navigation */
      nav {
        display: none !important;
      }

      /* Hide print buttons */
      .print\:hidden {
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
        margin-bottom: 12px !important;
      }

      .report-header h1 {
        font-size: 18px !important;
      }

      .report-header h2 {
        font-size: 14px !important;
      }

      .report-summary {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 8px !important;
        margin-bottom: 12px !important;
      }

      .summary-box {
        padding: 8px !important;
      }

      .summary-box h3 {
        font-size: 10px !important;
      }

      .summary-box p {
        font-size: 16px !important;
        margin-top: 3px !important;
      }

      .report-table-wrapper {
        overflow: visible !important;
      }

      .report-table {
        width: 100% !important;
        border-collapse: collapse !important;
        table-layout: auto !important;
      }

      .report-table th,
      .report-table td {
        border: 1px solid black !important;
        padding: 5px !important;
        font-size: 9px !important;
        color: black !important;
        word-break: normal !important;
      }

      .report-table th {
        background: #e5e5e5 !important;
      }

      .report-table tr {
        page-break-inside: avoid !important;
      }

      .signature-section {
        margin-top: 35px !important;
        gap: 35px 50px !important;
      }

      .signature-box {
        height: 65px !important;
        display: flex !important;
        align-items: flex-end !important;
        justify-content: center !important;
      }

      .signature-line {
        width: 75% !important;
        border-top: 1px solid black !important;
        padding-top: 5px !important;
        font-size: 10px !important;
      }
    }
  </style>
</x-app-layout>