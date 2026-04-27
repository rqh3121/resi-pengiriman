@extends('layouts.app')

@section('title', 'Buat Label Baru')

@section('content')
<div class="card-modern p-4">
    <h2 class="mb-4"><i class="fas fa-tag me-2"></i> Buat Pengiriman Baru</h2>
    <form action="{{ route('shipments.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <div class="bg-light p-3 rounded-4">
                    <h5><i class="fas fa-user-circle text-primary"></i> Pengirim</h5>

                    <!-- Dropdown alamat pengirim -->
                    <div class="mb-3">
                        <label>Pilih Alamat Pengirim (opsional)</label>
                        <select class="form-select" id="sender_address_select">
                            <option value="">-- Pilih Alamat --</option>
                            @foreach($senderAddresses as $addr)
                                <option value="{{ $addr->address }}" data-name="{{ $addr->name }}" data-contact="{{ $addr->contact }}">{{ $addr->name ?? $addr->address }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih alamat untuk mengisi nama, kontak, dan alamat pengirim otomatis</small>
                    </div>

                    <div class="mb-3">
                        <label>Nama / Perusahaan *</label>
                        <input type="text" name="sender_name" id="sender_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kontak *</label>
                        <input type="text" name="sender_contact" id="sender_contact" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Alamat Lengkap *</label>
                        <textarea name="sender_address" id="sender_address" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-light p-3 rounded-4">
                    <h5><i class="fas fa-user-check text-success"></i> Penerima</h5>

                    <!-- Dropdown proyek (wajib) -->
                    <div class="mb-3">
                        <label>Proyek <span class="text-danger">*</span></label>
                        <select name="project_id" class="form-select" required>
                            <option value="">-- Pilih Proyek --</option>
                            @foreach($projects as $proj)
                                <option value="{{ $proj->id }}" {{ old('project_id') == $proj->id ? 'selected' : '' }}>{{ $proj->judul_proyek }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown cabang PELNI (opsional) -->
                    <div class="mb-3">
                        <label>Pilih Cabang PELNI (opsional)</label>
                        <select class="form-select" id="branch_select">
                            <option value="">-- Pilih Cabang (isi otomatis) --</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->city }}" data-address="{{ $branch->address }}">{{ $branch->city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nama / PIC *</label>
                        <input type="text" name="receiver_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kontak *</label>
                        <input type="text" name="receiver_contact" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Alamat Lengkap *</label>
                        <textarea name="receiver_address" id="receiver_address" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Kota / Kabupaten *</label>
                        <input type="text" name="receiver_city" id="receiver_city" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah Paket *</label>
                        <input type="number" name="package_count" value="1" min="1" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan Barang</label>
                        <textarea name="item_description" class="form-control" rows="2" placeholder="Jenis, berat, dimensi..."></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 text-end">
            <a href="{{ route('shipments.index') }}" class="btn btn-secondary btn-modern">Batal</a>
            <button type="submit" class="btn btn-primary btn-modern">Simpan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Autofill pengirim
    document.getElementById('sender_address_select')?.addEventListener('change', function() {
        let opt = this.options[this.selectedIndex];
        let name = opt.getAttribute('data-name');
        let contact = opt.getAttribute('data-contact');
        let address = opt.value;
        if (address) {
            if (name) document.getElementById('sender_name').value = name;
            if (contact) document.getElementById('sender_contact').value = contact;
            document.getElementById('sender_address').value = address;
        }
    });

    // Autofill cabang penerima
    document.getElementById('branch_select')?.addEventListener('change', function() {
        let opt = this.options[this.selectedIndex];
        let city = opt.value;
        let addr = opt.getAttribute('data-address');
        if (city) {
            document.getElementById('receiver_city').value = city;
            document.getElementById('receiver_address').value = addr;
        }
    });
</script>
@endpush