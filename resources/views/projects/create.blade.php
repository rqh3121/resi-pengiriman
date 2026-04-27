@extends('layouts.app')

@section('title', 'Tambah Proyek')

@section('content')
<div class="card-modern p-4">
    <h2 class="mb-4">Tambah Proyek Baru</h2>
    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>No Proyek <span class="text-muted">(opsional)</span></label>
            <input type="text" name="no_proyek" class="form-control" value="{{ old('no_proyek') }}">
            <small class="text-muted">Kosongkan jika tidak ada nomor proyek.</small>
        </div>
        <div class="mb-3">
            <label>Judul Proyek <span class="text-danger">*</span></label>
            <input type="text" name="judul_proyek" class="form-control" value="{{ old('judul_proyek') }}" required>
        </div>
        <div class="mb-3">
            <label>SPK - optional</label>
            <input type="file" name="spk" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
        </div>
        <div class="mb-3">
            <label>SPMK - optional</label>
            <input type="file" name="spmk" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
        </div>
        <div class="mb-3">
            <label>BAKN - optional</label>
            <input type="file" name="bakn" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
        </div>
        <div class="text-end">
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Proyek</button>
        </div>
    </form>
</div>
@endsection