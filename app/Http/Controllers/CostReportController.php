<?php

namespace App\Http\Controllers;


use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CostReportExport;
use Barryvdh\DomPDF\Facade\Pdf;

class CostReportController extends Controller
{
    public function index(Request $request)
    {
        // Filter default: bulan dan tahun sekarang
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Data rekap per ekspedisi
        $reportData = Shipment::select(
                'expedition',
                DB::raw('COUNT(*) as total_shipments'),
                DB::raw('SUM(shipping_cost) as total_cost'),
                DB::raw('SUM(weight) as total_weight'),
                DB::raw('AVG(shipping_cost) as avg_cost_per_shipment')
            )
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->whereNotNull('shipping_cost')
            ->whereNotNull('expedition')
            ->groupBy('expedition')
            ->orderBy('total_cost', 'desc')
            ->get();

        // Data untuk grafik (label dan nilai)
        $labels = $reportData->pluck('expedition');
        $costs = $reportData->pluck('total_cost');
        $shipments = $reportData->pluck('total_shipments');

        // Total keseluruhan
        $grandTotalCost = $reportData->sum('total_cost');
        $grandTotalShipments = $reportData->sum('total_shipments');
        $grandTotalWeight = $reportData->sum('total_weight');

        return view('reports.cost', compact(
            'reportData', 'month', 'year', 
            'labels', 'costs', 'shipments',
            'grandTotalCost', 'grandTotalShipments', 'grandTotalWeight'
        ));
    }
    public function exportExcel(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        
        return Excel::download(new CostReportExport($month, $year), 'laporan-biaya-' . $month . '-' . $year . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Ambil data yang sama seperti di method index
        $reportData = Shipment::select(
                'expedition',
                \DB::raw('COUNT(*) as total_shipments'),
                \DB::raw('SUM(shipping_cost) as total_cost'),
                \DB::raw('SUM(weight) as total_weight'),
                \DB::raw('AVG(shipping_cost) as avg_cost_per_shipment')
            )
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->whereNotNull('shipping_cost')
            ->whereNotNull('expedition')
            ->groupBy('expedition')
            ->orderBy('total_cost', 'desc')
            ->get();

        $grandTotalCost = $reportData->sum('total_cost');
        $grandTotalShipments = $reportData->sum('total_shipments');
        $grandTotalWeight = $reportData->sum('total_weight');

        $pdf = Pdf::loadView('reports.cost-pdf', compact('reportData', 'month', 'year', 'grandTotalCost', 'grandTotalShipments', 'grandTotalWeight'));
        return $pdf->download('laporan-biaya-' . $month . '-' . $year . '.pdf');
    }
}