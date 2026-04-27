@extends('layouts.app')

@section('title', 'Manajemen Proyek')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="display-5 fw-bold">Daftar Proyek</h1>
    <a href="{{ route('projects.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Proyek Baru</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card-modern p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th>No</th>
                    <th>No Proyek</th>
                    <th>Judul Proyek</th>
                    <th>SPK</th>
                    <th>SPMK</th>
                    <th>BAKN</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $index => $p)
                <tr>
                    <td class="fw-bold">{{ $index + 1 }}</td>
                    <td>{{ $p->no_proyek ?: '-' }}</td>
                    <td>{{ $p->judul_proyek }}</td>
                    <td>
                        @if($p->spk)
                            <a href="{{ asset('storage/' . $p->spk) }}" target="_blank" class="btn btn-sm btn-info">Download</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($p->spmk)
                            <a href="{{ asset('storage/' . $p->spmk) }}" target="_blank" class="btn btn-sm btn-info">Download</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($p->bakn)
                            <a href="{{ asset('storage/' . $p->bakn) }}" target="_blank" class="btn btn-sm btn-info">Download</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('projects.show', $p) }}" class="btn btn-sm btn-primary">Detail</a>
                            <a href="{{ route('projects.edit', $p) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('projects.destroy', $p) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus proyek? Semua pengiriman akan tetap ada, namun tidak terikat proyek.')">Hapus</button>
                            </form>
                            <a href="{{ route('shipments.index', ['project_id' => $p->id]) }}" class="btn btn-sm btn-info">Lihat Pengiriman</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection