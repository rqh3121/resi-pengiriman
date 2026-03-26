<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::latest()->get();
        return view('shipments.index', compact('shipments'));
    }

    public function create()
    {
        return view('shipments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sender_name' => 'required',
            'sender_contact' => 'required',
            'sender_address' => 'required',
            'receiver_name' => 'required',
            'receiver_contact' => 'required',
            'receiver_address' => 'required',
            'receiver_city' => 'required',
        ]);

        Shipment::create($request->all());

        return redirect()->route('shipments.index')->with('success', 'Data pengiriman berhasil disimpan.');
    }

    public function show(Shipment $shipment)
    {
        return view('shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        return view('shipments.edit', compact('shipment'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $request->validate([
            'sender_name' => 'required',
            'sender_contact' => 'required',
            'sender_address' => 'required',
            'receiver_name' => 'required',
            'receiver_contact' => 'required',
            'receiver_address' => 'required',
            'receiver_city' => 'required',
        ]);

        $shipment->update($request->all());

        return redirect()->route('shipments.index')->with('success', 'Data pengiriman berhasil diperbarui.');
    }

    public function print(Shipment $shipment, $size = 'a4')
    {
        $allowedSizes = ['a4', 'a5', 'a6'];
        if (!in_array($size, $allowedSizes)) {
            $size = 'a4';
        }

        // Mapping ukuran untuk CSS @page
        $paperSizes = [
            'a4' => ['width' => '210mm', 'height' => '297mm'],
            'a5' => ['width' => '148mm', 'height' => '210mm'],
            'a6' => ['width' => '105mm', 'height' => '148mm'],
        ];

        $paper = $paperSizes[$size];

        $pdf = Pdf::loadView('shipments.label', compact('shipment', 'size', 'paper'));
        $pdf->setPaper($size);
        return $pdf->stream('label-'.$shipment->id.'.pdf');
    }
        public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return redirect()->route('shipments.index')->with('success', 'Data pengiriman berhasil dihapus.');
    }
}