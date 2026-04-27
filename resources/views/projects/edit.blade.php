@extends('layouts.app')

@section('title', 'Edit Proyek')

@section('content')
<div class="card-modern p-4">
    <h2 class="mb-4">Edit Proyek: {{ $project->judul_proyek }}</h2>
    <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>No Proyek <span class="text-muted">(opsional)</span></label>
            <input type="text" name="no_proyek" class="form-control" value="{{ old('no_proyek', $project->no_proyek) }}">
        </div>
        <div class="mb-3">
            <label>Judul Proyek <span class="text-danger">*</span></label>
            <input type="text" name="judul_proyek" class="form-control" value="{{ old('judul_proyek', $project->judul_proyek) }}" required>
        </div>
        <div class="mb-3">
            <label>SPK - optional</label>
            <input type="file" name="spk" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
            @if($project->spk) <div class="mt-2"><a href="{{ asset('storage/' . $project->spk) }}" target="_blank">Download SPK saat ini</a></div> @endif
        </div>
        <div class="mb-3">
            <label>SPMK - optional</label>
            <input type="file" name="spmk" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
            @if($project->spmk) <div class="mt-2"><a href="{{ asset('storage/' . $project->spmk) }}" target="_blank">Download SPMK saat ini</a></div> @endif
        </div>
        <div class="mb-3">
            <label>BAKN - optional</label>
            <input type="file" name="bakn" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
            @if($project->bakn) <div class="mt-2"><a href="{{ asset('storage/' . $project->bakn) }}" target="_blank">Download BAKN saat ini</a></div> @endif
        </div>
        <div class="text-end">
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update Proyek</button>
        </div>
    </form>
</div>
@endsection