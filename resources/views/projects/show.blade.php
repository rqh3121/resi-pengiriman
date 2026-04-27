@extends('layouts.app')

@section('title', 'Detail Proyek')

@section('content')
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Detail Proyek</h2>
        <div>
            <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">Edit Proyek</a>
            <a href="{{ route('shipments.index', ['project_id' => $project->id]) }}" class="btn btn-info">Lihat Pengiriman</a>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <table class="table table-bordered">
        <tr><th>No Proyek</th><td>{{ $project->no_proyek ?: '-' }}</td></tr>
        <tr><th>Judul Proyek</th><td>{{ $project->judul_proyek }}</td></tr>
        <tr><th>SPK</th><td>@if($project->spk) <a href="{{ asset('storage/' . $project->spk) }}" target="_blank">Download</a> @else - @endif</td></tr>
        <tr><th>SPMK</th><td>@if($project->spmk) <a href="{{ asset('storage/' . $project->spmk) }}" target="_blank">Download</a> @else - @endif</td></tr>
        <tr><th>BAKN</th><td>@if($project->bakn) <a href="{{ asset('storage/' . $project->bakn) }}" target="_blank">Download</a> @else - @endif</td></tr>
        <tr><th>Dibuat</th><td>{{ $project->created_at->format('d/m/Y H:i') }}</td></tr>
        <tr><th>Terakhir diupdate</th><td>{{ $project->updated_at->format('d/m/Y H:i') }}</td></tr>
    </table>
</div>
@endsection