<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CostReportController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Models\Shipment;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman root -> redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route autentikasi dari Breeze
require __DIR__.'/auth.php';

// Semua route yang membutuhkan login
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource Projects (CRUD proyek)
    Route::resource('projects', ProjectController::class);

    // Resource Shipments (CRUD pengiriman)
    Route::resource('shipments', ShipmentController::class);

    // Update resi (AJAX)
    Route::post('/shipments/{shipment}/resi', [ShipmentController::class, 'updateResi'])->name('shipments.updateResi');

    // Cetak label (A4/A5/A6)
    Route::get('shipments/{shipment}/print/{size?}', [ShipmentController::class, 'print'])->name('shipments.print');

    // Laporan biaya
    Route::get('/reports/cost', [CostReportController::class, 'index'])->name('reports.cost');
    Route::get('/reports/cost/export-excel', [CostReportController::class, 'exportExcel'])->name('reports.cost.export.excel');
    Route::get('/reports/cost/export-pdf', [CostReportController::class, 'exportPdf'])->name('reports.cost.export.pdf');

    // Laporan pengiriman per bulan
    Route::get('/laporan', function (Request $request) {
        $tahun = $request->input('tahun', date('Y'));
        $shipments = Shipment::selectRaw('
                MONTH(created_at) as bulan,
                COUNT(*) as total_shipments,
                SUM(package_count) as total_packages,
                SUM(weight) as total_weight,
                SUM(shipping_cost) as total_cost
            ')
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get()
            ->map(function($item) {
                $item->bulan_nama = date('F', mktime(0,0,0,$item->bulan,1));
                return $item;
            });
        return view('laporan', compact('shipments'));
    })->name('laporan');

    // Profile routes dari Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});