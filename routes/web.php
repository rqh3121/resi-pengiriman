<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman root: redirect ke login (jika belum login) atau ke dashboard (jika sudah login)
Route::get('/', function () {
    return redirect()->route('login');
});

// Route autentikasi (login, register, logout, dll.) disediakan oleh Breeze
require __DIR__.'/auth.php';

// Route yang membutuhkan autentikasi
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource Shipments (CRUD)
    Route::resource('shipments', ShipmentController::class);

    // Update resi (AJAX)
    Route::post('/shipments/{shipment}/resi', [ShipmentController::class, 'updateResi'])->name('shipments.updateResi');

    // Cetak label dengan ukuran (A4/A5/A6)
    Route::get('shipments/{shipment}/print/{size?}', [ShipmentController::class, 'print'])->name('shipments.print');

    // Laporan sederhana
    Route::get('/laporan', function () {
        $shipments = App\Models\Shipment::selectRaw('MONTH(created_at) as bulan, YEAR(created_at) as tahun, COUNT(*) as total')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
        return view('laporan', compact('shipments'));
    })->name('laporan');

    // Profile routes (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});