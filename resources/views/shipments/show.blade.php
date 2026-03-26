@extends('layouts.app')

@section('title', 'Detail Pengiriman #' . $shipment->id)

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-info text-white py-3">
        <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i> Detail Pengiriman #{{ $shipment->id }}</h4>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="border p-3 rounded-3 bg-light h-100">
                    <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-user-circle text-primary me-2"></i> Pengirim</h5>
                    <p class="mb-1"><strong>{{ $shipment->sender_name }}</strong></p>
                    <p class="mb-1"><i class="fas fa-phone-alt me-2 text-muted"></i> {{ $shipment->sender_contact }}</p>
                    <p class="mb-0"><i class="fas fa-map-marker-alt me-2 text-muted"></i> {{ nl2br($shipment->sender_address) }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border p-3 rounded-3 bg-light h-100">
                    <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-user-check text-success me-2"></i> Penerima</h5>
                    <p class="mb-1"><strong>{{ $shipment->receiver_name }}</strong></p>
                    <p class="mb-1"><i class="fas fa-phone-alt me-2 text-muted"></i> {{ $shipment->receiver_contact }}</p>
                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-muted"></i> {{ nl2br($shipment->receiver_address) }}</p>
                    <p class="mb-0"><strong class="text-uppercase"><i class="fas fa-city me-2 text-muted"></i> {{ strtoupper($shipment->receiver_city) }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Informasi Resi (ditampilkan jika ada data) -->
        @if(!empty($shipment->resi_number) || !empty($shipment->expedition) || !empty($shipment->resi_photo))
        <div class="row mt-4">
            <div class="col-12">
                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-truck text-primary me-2"></i> Informasi Resi</h5>
            </div>
            <div class="col-md-4">
                <div class="border p-3 rounded-3 bg-light h-100">
                    <div class="text-muted mb-1"><small>Nomor Resi</small></div>
                    <strong>{{ $shipment->resi_number ?? '-' }}</strong>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border p-3 rounded-3 bg-light h-100">
                    <div class="text-muted mb-1"><small>Ekspedisi</small></div>
                    <strong>{{ $shipment->expedition ?? '-' }}</strong>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border p-3 rounded-3 bg-light h-100">
                    <div class="text-muted mb-1"><small>Foto Resi</small></div>
                    @if($shipment->resi_photo)
                        <a href="{{ asset('storage/' . $shipment->resi_photo) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-image me-1"></i> Lihat Foto
                        </a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <hr class="my-4">

        <div class="d-flex justify-content-end gap-2">
            <div class="btn-group" role="group">
                <a href="{{ route('shipments.print', ['shipment' => $shipment, 'size' => 'a4']) }}" class="btn btn-primary" target="_blank">
                    <i class="fas fa-print me-1"></i> Cetak A4
                </a>
                <a href="{{ route('shipments.print', ['shipment' => $shipment, 'size' => 'a5']) }}" class="btn btn-primary" target="_blank">A5</a>
                <a href="{{ route('shipments.print', ['shipment' => $shipment, 'size' => 'a6']) }}" class="btn btn-primary" target="_blank">A6</a>
            </div>
            <form action="{{ route('shipments.destroy', $shipment) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    <i class="fas fa-trash-alt me-1"></i> Hapus
                </button>
            </form>
            <a href="{{ route('shipments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection