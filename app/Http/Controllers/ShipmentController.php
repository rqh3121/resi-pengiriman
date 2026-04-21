<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Branch;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\SenderAddress; // tambahkan ini

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
        $branches = Branch::orderBy('city')->get();
        $senderAddresses = SenderAddress::all(); // ambil semua alamat pengirim
        return view('shipments.create', compact('branches', 'senderAddresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sender_name'     => 'required',
            'sender_contact'  => 'required',
            'sender_address'  => 'required',
            'receiver_name'   => 'required',
            'receiver_contact'=> 'required',
            'receiver_address'=> 'required',
            'receiver_city'   => 'required',
            'package_count'   => 'required|integer|min:1',
            'item_description'=> 'nullable|string',
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
        $branches = Branch::orderBy('city')->get();
        $senderAddresses = SenderAddress::all();
        return view('shipments.edit', compact('shipment', 'branches', 'senderAddresses'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $request->validate([
            'sender_name'     => 'required',
            'sender_contact'  => 'required',
            'sender_address'  => 'required',
            'receiver_name'   => 'required',
            'receiver_contact'=> 'required',
            'receiver_address'=> 'required',
            'receiver_city'   => 'required',
            'package_count'   => 'required|integer|min:1',
            'item_description'=> 'nullable|string',
        ]);

        $shipment->update($request->all());
        return redirect()->route('shipments.index')->with('success', 'Data pengiriman berhasil diperbarui.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return redirect()->route('shipments.index')->with('success', 'Data pengiriman berhasil dihapus.');
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

        // Pastikan setPaper menggunakan ukuran yang sama
        $pdf->setPaper($size);
        return $pdf->stream('label-'.$shipment->id.'.pdf');
    }

    public function updateResi(Request $request, Shipment $shipment)
    {
        $request->validate([
            'resi_number' => 'nullable|string|max:255',
            'expedition'  => 'nullable|string|max:100',
            'resi_photo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'weight'      => 'nullable|numeric|min:0',
            'shipping_cost'=> 'nullable|numeric|min:0',
        ]);

        $data = $request->only(['resi_number', 'expedition', 'weight', 'shipping_cost']);

        if ($request->hasFile('resi_photo')) {
            if ($shipment->resi_photo && Storage::disk('public')->exists($shipment->resi_photo)) {
                Storage::disk('public')->delete($shipment->resi_photo);
            }
            $path = $request->file('resi_photo')->store('resi_photos', 'public');
            $data['resi_photo'] = $path;
        }

        $shipment->update($data);

        return response()->json(['success' => true]);
    }
    public function getSidebarStats()
    {
        $today = now()->toDateString();
        return [
            'today_shipments' => Shipment::whereDate('created_at', $today)->count(),
            'pending_resi'    => Shipment::whereNull('resi_number')->orWhereNull('expedition')->count(),
            'total_packages'  => Shipment::sum('package_count'),
            'active_projects' => Shipment::distinct('project_name')->count('project_name'), // jika ada kolom project_name
        ];
    }

}