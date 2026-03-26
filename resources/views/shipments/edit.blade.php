@extends('layouts.app')

@section('title', 'Edit Pengiriman #' . $shipment->id)

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-warning text-dark py-3">
        <h4 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Pengiriman #{{ $shipment->id }}</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('shipments.update', $shipment) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <!-- sama dengan create, tetapi value diisi dengan $shipment -->
                <div class="col-md-6">
                    <div class="border p-3 rounded-3 bg-light">
                        <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-user-circle text-primary me-2"></i> Data Pengirim</h5>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama / Perusahaan</label>
                            <input type="text" class="form-control" name="sender_name" value="{{ old('sender_name', $shipment->sender_name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kontak</label>
                            <input type="text" class="form-control" name="sender_contact" value="{{ old('sender_contact', $shipment->sender_contact) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea class="form-control" name="sender_address" rows="4" required>{{ old('sender_address', $shipment->sender_address) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border p-3 rounded-3 bg-light">
                        <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-user-check text-success me-2"></i> Data Penerima</h5>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama / PIC</label>
                            <input type="text" class="form-control" name="receiver_name" value="{{ old('receiver_name', $shipment->receiver_name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kota / Kabupaten</label>
                            <input type="text" class="form-control" name="receiver_city" value="{{ old('receiver_city', $shipment->receiver_city) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kontak</label>
                            <input type="text" class="form-control" name="receiver_contact" value="{{ old('receiver_contact', $shipment->receiver_contact) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea class="form-control" name="receiver_address" rows="3" required>{{ old('receiver_address', $shipment->receiver_address) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('shipments.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
            </div>
        </form>
    </div>
</div>
@endsection