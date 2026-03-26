@extends('layouts.app')

@section('title', 'Daftar Pengiriman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="display-6 fw-bold">
        <i class="fas fa-list-alt text-primary me-2"></i> Daftar Pengiriman
    </h1>
    <a href="{{ route('shipments.create') }}" class="btn btn-success btn-lg">
        <i class="fas fa-plus-circle me-2"></i> Tambah Baru
    </a>
</div>

@if($shipments->isEmpty())
    <div class="alert alert-info text-center shadow-sm">
        <i class="fas fa-info-circle me-2"></i> Belum ada data pengiriman. Silakan tambahkan data baru.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><i class="fas fa-user"></i> Pengirim</th>
                    <th><i class="fas fa-user-check"></i> Penerima</th>
                    <th><i class="fas fa-calendar-alt"></i> Tanggal</th>
                    <th><i class="fas fa-cogs"></i> Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shipments as $shipment)
                <tr>
                    <td class="fw-bold">#{{ $shipment->id }}</td>
                    <td>
                        <strong>{{ $shipment->sender_name }}</strong><br>
                        <small class="text-muted">{{ $shipment->sender_contact }}</small>
                    </td>
                    <td>
                        <strong>{{ $shipment->receiver_name }}</strong><br>
                        <small class="text-muted">{{ $shipment->receiver_contact }}</small>
                    </td>
                    <td>{{ $shipment->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('shipments.destroy', $shipment) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('shipments.print', ['shipment' => $shipment, 'size' => 'a4']) }}" class="btn btn-primary" target="_blank" title="Cetak A4">
                                    <i class="fas fa-print"></i> A4
                                </a>
                                <a href="{{ route('shipments.print', ['shipment' => $shipment, 'size' => 'a5']) }}" class="btn btn-primary" target="_blank" title="Cetak A5">
                                    A5
                                </a>
                                <a href="{{ route('shipments.print', ['shipment' => $shipment, 'size' => 'a6']) }}" class="btn btn-primary" target="_blank" title="Cetak A6">
                                    A6
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection