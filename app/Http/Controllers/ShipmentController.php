<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $shipments = Shipment::query();

        if ($search) {
            $shipments->where(function ($q) use ($search) {
                $q->where('sender_name', 'LIKE', "%{$search}%")
                  ->orWhere('receiver_name', 'LIKE', "%{$search}%")
                  ->orWhere('receiver_city', 'LIKE', "%{$search}%");
            });
        }

        $shipments = $shipments->latest()->get();

        return view('shipments.index', compact('shipments', 'search'));
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
            'package_count' => 'required|integer|min:1',
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
            'package_count' => 'required|integer|min:1',
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

        $paperSizes = [
            'a4' => ['width' => '210mm', 'height' => '297mm'],
            'a5' => ['width' => '148mm', 'height' => '210mm'],
            'a6' => ['width' => '105mm', 'height' => '148mm'],
        ];
        $paper = $paperSizes[$size];

        $totalPages = $shipment->package_count;

        if ($totalPages <= 1) {
            $pdf = Pdf::loadView('shipments.label', compact('shipment', 'size', 'paper'));
        } else {
            $pdf = Pdf::loadView('shipments.label-multi', compact('shipment', 'size', 'paper', 'totalPages'));
        }

        $pdf->setPaper($size);
        return $pdf->stream('label-'.$shipment->id.'.pdf');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return redirect()->route('shipments.index')->with('success', 'Data pengiriman berhasil dihapus.');
    }

    public function updateResi(Request $request, Shipment $shipment)
    {
        $request->validate([
            'resi_number' => 'nullable|string|max:255',
            'expedition'  => 'nullable|string|max:100',
            'resi_photo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'resi_number' => $request->resi_number,
            'expedition'  => $request->expedition,
        ];

        if ($request->hasFile('resi_photo')) {
            // Hapus foto lama jika ada
            if ($shipment->resi_photo && Storage::disk('public')->exists($shipment->resi_photo)) {
                Storage::disk('public')->delete($shipment->resi_photo);
            }
            $path = $request->file('resi_photo')->store('resi_photos', 'public');
            $data['resi_photo'] = $path;
        }

        $shipment->update($data);

        return response()->json(['success' => true]);
    }
    public function updateResiSimple(Request $request, Shipment $shipment)
    {
        $shipment->update([
            'resi_number' => $request->resi_number,
            'expedition'  => $request->expedition,
        ]);
        return redirect()->route('shipments.index')->with('success', 'Resi berhasil diperbarui');
    }
    public function updateResiTest(Request $request, Shipment $shipment)
    {
        $shipment->update([
            'resi_number' => $request->resi_number,
            'expedition'  => $request->expedition,
        ]);
        return redirect()->route('shipments.index')->with('success', 'Resi berhasil diperbarui');
    }
}