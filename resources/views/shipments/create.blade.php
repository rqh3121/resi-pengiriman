@extends('layouts.app')

@section('title', 'Buat Label Baru')

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-primary text-white py-3">
        <h4 class="mb-0"><i class="fas fa-tag me-2"></i> Buat Label Pengiriman Baru</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('shipments.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="border p-3 rounded-3 bg-light">
                        <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-user-circle text-primary me-2"></i> Data Pengirim</h5>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama / Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('sender_name') is-invalid @enderror" name="sender_name" value="{{ old('sender_name') }}" placeholder="Contoh: PT PELITA INDONESIA DJAYA" required>
                            @error('sender_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kontak <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('sender_contact') is-invalid @enderror" name="sender_contact" value="{{ old('sender_contact') }}" placeholder="No. Telepon / HP" required>
                            @error('sender_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('sender_address') is-invalid @enderror" name="sender_address" rows="4" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota" required>{{ old('sender_address') }}</textarea>
                            @error('sender_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border p-3 rounded-3 bg-light">
                        <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-user-check text-success me-2"></i> Data Penerima</h5>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama / PIC <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('receiver_name') is-invalid @enderror" name="receiver_name" value="{{ old('receiver_name') }}" placeholder="Contoh: ABDUL BUHARI" required>
                            @error('receiver_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kota / Kabupaten <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('receiver_city') is-invalid @enderror" name="receiver_city" value="{{ old('receiver_city') }}" placeholder="Contoh: MAKASSAR" required>
                            @error('receiver_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="package_count" class="form-label">Jumlah Package (Paket) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('package_count') is-invalid @enderror" id="package_count" name="package_count" value="{{ old('package_count', 1) }}" min="1" required>
                            @error('package_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kontak <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('receiver_contact') is-invalid @enderror" name="receiver_contact" value="{{ old('receiver_contact') }}" placeholder="No. Telepon / HP" required>
                            @error('receiver_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('receiver_address') is-invalid @enderror" name="receiver_address" rows="3" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan" required>{{ old('receiver_address') }}</textarea>
                            @error('receiver_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('shipments.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan & Cetak Label</button>
            </div>
        </form>
    </div>
</div>
@endsection