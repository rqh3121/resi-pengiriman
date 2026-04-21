<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $totalShipments = Shipment::count();
    $totalPackages = Shipment::sum('package_count');
    $pendingResi = Shipment::whereNull('resi_number')->orWhereNull('expedition')->count();
    $completedResi = Shipment::whereNotNull('resi_number')->whereNotNull('expedition')->count();

    // Data untuk grafik 7 hari terakhir
    $shipmentsPerDay = Shipment::selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->limit(7)
        ->get();

    // Top 5 cabang tujuan (kota penerima)
    $topCities = Shipment::select('receiver_city', \DB::raw('count(*) as total'))
        ->groupBy('receiver_city')
        ->orderBy('total', 'desc')
        ->limit(5)
        ->get();

    // Top 5 ekspedisi yang sering digunakan
    $topExpeditions = Shipment::whereNotNull('expedition')
        ->select('expedition', \DB::raw('count(*) as total'))
        ->groupBy('expedition')
        ->orderBy('total', 'desc')
        ->limit(5)
        ->get();

    // 5 pengiriman terbaru
    $recentShipments = Shipment::latest()->limit(5)->get();

    return view('dashboard', compact(
        'totalShipments', 'totalPackages', 'pendingResi', 'completedResi',
        'shipmentsPerDay', 'topCities', 'topExpeditions', 'recentShipments'
    ));
}
}