@extends('layouts.app')
@section('title', 'Edit Pengiriman #'.$shipment->id)
@section('content')
<div class="card-modern p-4"><h2 class="mb-4"><i class="fas fa-edit me-2"></i> Edit Pengiriman #{{ $shipment->id }}</h2>
<form action="{{ route('shipments.update', $shipment) }}" method="POST">@csrf @method('PUT')
<div class="row g-4"><div class="col-md-6"><div class="bg-light p-3 rounded-4"><h5><i class="fas fa-user-circle text-primary"></i> Pengirim</h5>
<div class="mb-3"><label>Pilih Alamat Pengirim (opsional)</label>
<select class="form-select" id="sender_address_select"><option value="">-- Pilih Alamat --</option>@foreach($senderAddresses as $addr)<option value="{{ $addr->address }}" data-name="{{ $addr->name }}" data-contact="{{ $addr->contact }}" {{ old('sender_address', $shipment->sender_address) == $addr->address ? 'selected' : '' }}>{{ $addr->name ?? $addr->address }}</option>@endforeach</select></div>
<div class="mb-3"><label>Nama / Perusahaan</label><input type="text" name="sender_name" id="sender_name" class="form-control" value="{{ old('sender_name', $shipment->sender_name) }}" required></div>
<div class="mb-3"><label>Kontak</label><input type="text" name="sender_contact" id="sender_contact" class="form-control" value="{{ old('sender_contact', $shipment->sender_contact) }}" required></div>
<div class="mb-3"><label>Alamat Lengkap</label><textarea name="sender_address" id="sender_address" class="form-control" rows="4" required>{{ old('sender_address', $shipment->sender_address) }}</textarea></div></div></div>
<div class="col-md-6"><div class="bg-light p-3 rounded-4"><h5><i class="fas fa-user-check text-success"></i> Penerima</h5>
<div class="mb-3"><label>Pilih Cabang PELNI (opsional)</label><select class="form-select" id="branch_select"><option value="">-- Pilih Cabang --</option>@foreach($branches as $branch)<option value="{{ $branch->city }}" data-address="{{ $branch->address }}" {{ old('receiver_city', $shipment->receiver_city) == $branch->city ? 'selected' : '' }}>{{ $branch->city }}</option>@endforeach</select></div>
<div class="mb-3"><label>Nama / PIC</label><input type="text" name="receiver_name" class="form-control" value="{{ old('receiver_name', $shipment->receiver_name) }}" required></div>
<div class="mb-3"><label>Kontak</label><input type="text" name="receiver_contact" class="form-control" value="{{ old('receiver_contact', $shipment->receiver_contact) }}" required></div>
<div class="mb-3"><label>Alamat Lengkap</label><textarea name="receiver_address" id="receiver_address" class="form-control" rows="3" required>{{ old('receiver_address', $shipment->receiver_address) }}</textarea></div>
<div class="mb-3"><label>Kota / Kabupaten</label><input type="text" name="receiver_city" id="receiver_city" class="form-control" value="{{ old('receiver_city', $shipment->receiver_city) }}" required></div>
<div class="mb-3"><label>Jumlah Paket</label><input type="number" name="package_count" value="{{ old('package_count', $shipment->package_count) }}" min="1" class="form-control" required></div>
<div class="mb-3"><label>Keterangan Barang</label><textarea name="item_description" class="form-control" rows="2">{{ old('item_description', $shipment->item_description) }}</textarea></div></div></div></div>
<div class="mt-4 text-end"><a href="{{ route('shipments.index') }}" class="btn btn-secondary btn-modern">Batal</a><button type="submit" class="btn btn-primary btn-modern">Update</button></div></form></div>
@endsection
@push('scripts')
<script>
document.getElementById('sender_address_select')?.addEventListener('change',function(){let opt=this.options[this.selectedIndex];let addr=opt.value;let name=opt.getAttribute('data-name');let contact=opt.getAttribute('data-contact');if(addr){if(name)document.getElementById('sender_name').value=name;if(contact)document.getElementById('sender_contact').value=contact;document.getElementById('sender_address').value=addr;}});
document.getElementById('branch_select')?.addEventListener('change',function(){let opt=this.options[this.selectedIndex];let city=opt.value;let addr=opt.getAttribute('data-address');if(city){document.getElementById('receiver_city').value=city;document.getElementById('receiver_address').value=addr;}});
</script>
@endpush