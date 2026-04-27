<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CostReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CostReportController extends Controller
{
    public function index(Request $request)
    {
        $project_id = $request->input('project_id');
        $bulan = $request->input('bulan', 'all');
        $projects = Project::orderBy('judul_proyek')->get();

        $query = Shipment::select(
                'expedition',
                DB::raw('COUNT(*) as total_shipments'),
                DB::raw('SUM(shipping_cost) as total_cost'),
                DB::raw('SUM(weight) as total_weight')
            )
            ->whereNotNull('shipping_cost')
            ->whereNotNull('expedition');

        if ($project_id) {
            $query->where('project_id', $project_id);
        }

        if ($bulan !== 'all') {
            $query->whereMonth('created_at', $bulan);
        }

        $reportData = $query->groupBy('expedition')
            ->orderBy('total_cost', 'desc')
            ->get();

        $labels = $reportData->pluck('expedition');
        $costs = $reportData->pluck('total_cost');
        $shipments = $reportData->pluck('total_shipments');

        $grandTotalCost = $reportData->sum('total_cost');
        $grandTotalShipments = $reportData->sum('total_shipments');
        $grandTotalWeight = $reportData->sum('total_weight');

        return view('reports.cost', compact(
            'reportData', 'project_id', 'bulan', 'projects',
            'labels', 'costs', 'shipments',
            'grandTotalCost', 'grandTotalShipments', 'grandTotalWeight'
        ));
    }

    public function exportPdf(Request $request)
    {
        $project_id = $request->input('project_id');
        $bulan = $request->input('bulan', 'all');

        // Data per cabang dan ekspedisi (detail)
        $detailStats = Shipment::select(
                'receiver_city',
                'expedition',
                DB::raw('SUM(package_count) as total_paket'),
                DB::raw('SUM(weight) as total_berat'),
                DB::raw('SUM(shipping_cost) as total_biaya')
            )
            ->whereNotNull('receiver_city')
            ->whereNotNull('expedition')
            ->whereNotNull('shipping_cost');

        if ($project_id) {
            $detailStats->where('project_id', $project_id);
        }
        if ($bulan !== 'all') {
            $detailStats->whereMonth('created_at', $bulan);
        }

        $detailStats = $detailStats->groupBy('receiver_city', 'expedition')
            ->orderBy('receiver_city')
            ->orderBy('expedition')
            ->get();

        // Total keseluruhan
        $queryTotal = Shipment::select(
                DB::raw('SUM(package_count) as total_paket'),
                DB::raw('SUM(weight) as total_berat'),
                DB::raw('SUM(shipping_cost) as total_biaya'),
                DB::raw('COUNT(*) as total_pengiriman')
            )
            ->whereNotNull('shipping_cost');

        if ($project_id) $queryTotal->where('project_id', $project_id);
        if ($bulan !== 'all') $queryTotal->whereMonth('created_at', $bulan);
        $total = $queryTotal->first();

        $grandTotalShipments = $total->total_pengiriman ?? 0;
        $grandTotalCost = $total->total_biaya ?? 0;
        $grandTotalWeight = $total->total_berat ?? 0;

        $bulan_nama = ($bulan == 'all') ? 'Semua Bulan' : date('F', mktime(0,0,0,$bulan,1));

        // Generate nomor surat
        $nomor_surat = 'LPB/' . ($project_id ?? 'ALL') . '/' . date('m') . '/' . date('Y');

        $pdf = Pdf::loadView('reports.cost-pdf', compact(
            'detailStats',
            'project_id', 'bulan', 'bulan_nama',
            'grandTotalCost', 'grandTotalShipments', 'grandTotalWeight',
            'nomor_surat'
        ));

        return $pdf->download('laporan-biaya.pdf');
    }
}