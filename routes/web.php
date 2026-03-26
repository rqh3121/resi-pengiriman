<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentController;

Route::get('/', function () {
    return redirect()->route('shipments.index');
});

Route::resource('shipments', ShipmentController::class);
Route::get('shipments/{shipment}/print/{size?}', [ShipmentController::class, 'print'])->name('shipments.print');
Route::post('/shipments/{shipment}/resi', [ShipmentController::class, 'updateResi'])->name('shipments.updateResi');
Route::post('/shipments/{shipment}/resi-simple', [ShipmentController::class, 'updateResiSimple'])->name('shipments.updateResiSimple');
Route::post('/shipments/{shipment}/resi-test', [ShipmentController::class, 'updateResiTest'])->name('shipments.updateResiTest');



