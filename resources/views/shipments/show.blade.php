@extends('layouts.app')
@section('title', 'Detail Pengiriman #'.$shipment->id)
@section('content')
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Detail Pengiriman #{{ $shipment->id }}</h2>
        <a href="{{ route('shipments.index') }}" class="btn btn-secondary btn-modern"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="bg-light p-4 rounded-4 h-100">
                <h5 class="border-bottom pb-2"><i class="fas fa-user-circle text-primary"></i> Pengirim</h5>
                <p><strong>{{ $shipment->sender_name }}</strong><br>{{ $shipment->sender_contact }}<br>{{ nl2br($shipment->sender_address) }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="bg-light p-4 rounded-4 h-100">
                <h5 class="border-bottom pb-2"><i class="fas fa-user-check text-success"></i> Penerima</h5>
                <p><strong>{{ $shipment->receiver_name }}</strong><br>{{ $shipment->receiver_contact }}<br>{{ nl2br($shipment->receiver_address) }}<br><span class="badge bg-primary mt-2">{{ strtoupper($shipment->receiver_city) }}</span></p>
            </div>
        </div>
    </div>

    <!-- Jumlah Paket -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="bg-light p-4 rounded-4">
                <h5><i class="fas fa-boxes"></i> Jumlah Paket</h5>
                <p class="display-6 fw-bold">{{ $shipment->package_count }} paket</p>
            </div>
        </div>
        @if($shipment->item_description)
        <div class="col-md-6">
            <div class="bg-light p-4 rounded-4">
                <h5><i class="fas fa-box-open"></i> Keterangan Barang</h5>
                <p class="mb-0">{{ nl2br($shipment->item_description) }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Informasi Resi jika ada -->
    @if(!empty($shipment->resi_number) || !empty($shipment->expedition) || !empty($shipment->resi_photo))
    <div class="row mt-4">
        <div class="col-12">
            <h5><i class="fas fa-truck"></i> Informasi Resi</h5>
            <hr>
        </div>
        <div class="col-md-4">
            <strong>Nomor Resi:</strong> {{ $shipment->resi_number ?? '-' }}
        </div>
        <div class="col-md-4">
            <strong>Ekspedisi:</strong> {{ $shipment->expedition ?? '-' }}
        </div>
        <div class="col-md-4">
            <strong>Foto Resi:</strong>
            @if($shipment->resi_photo)
                <a href="{{ asset('storage/' . $shipment->resi_photo) }}" target="_blank">Lihat Foto</a>
            @else
                -
            @endif
        </div>
    </div>
    @endif

    <div class="mt-4 text-end">
        <div class="btn-group">
            <a href="{{ route('shipments.print', [$shipment, 'a4']) }}" class="btn btn-primary rounded-pill" target="_blank">Cetak A4</a>
            <a href="{{ route('shipments.print', [$shipment, 'a5']) }}" class="btn btn-primary rounded-pill" target="_blank">Cetak A5</a>
            <a href="{{ route('shipments.print', [$shipment, 'a6']) }}" class="btn btn-primary rounded-pill" target="_blank">Cetak A6</a>
        </div>
        <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-warning rounded-pill">Edit</a>
        <form method="POST" action="{{ route('shipments.destroy', $shipment) }}" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger rounded-pill" onclick="return confirm('Yakin hapus?')">Hapus</button>
        </form>
    </div>
</div>
@endsection