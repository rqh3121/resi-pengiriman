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
        $shipmentsPerDay = Shipment::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        return view('dashboard', compact('totalShipments', 'totalPackages', 'pendingResi', 'completedResi', 'shipmentsPerDay'));
    }
}