<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentController;

Route::get('/', function () {
    return redirect()->route('shipments.index');
});

Route::resource('shipments', ShipmentController::class);
Route::get('shipments/{shipment}/print/{size?}', [ShipmentController::class, 'print'])->name('shipments.print');