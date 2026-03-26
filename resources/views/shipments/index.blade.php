@extends('layouts.app')

@section('title', 'Daftar Pengiriman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="display-6 fw-bold">
        <i class="fas fa-list-alt text-primary me-2"></i> Daftar Pengiriman
    </h1>
    <a href="{{ route('shipments.create') }}" class="btn btn-success btn-lg">
        <i class="fas fa-plus-circle me-2"></i> Tambah Baru
    </a>
</div>

<!-- Form Pencarian -->
<form method="GET" action="{{ route('shipments.index') }}" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Cari pengirim, penerima, atau kota..." value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
        @if(request('search'))
            <a href="{{ route('shipments.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Reset</a>
        @endif
    </div>
</form>

@if($shipments->isEmpty())
    <div class="alert alert-info text-center shadow-sm">
        <i class="fas fa-info-circle me-2"></i> Belum ada data pengiriman. Silakan tambahkan data baru.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                 <tr>
                    <th>No</th>
                    <th>Pengirim</th>
                    <th>Penerima</th>
                    <th>Tanggal</th>
                    <th>No Resi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shipments as $index => $shipment)
                <tr>
                    <td class="fw-bold">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $shipment->sender_name }}</strong><br>
                        <small class="text-muted">{{ $shipment->sender_contact }}</small>
                    </td>
                    <td>
                        <strong>{{ $shipment->receiver_name }}</strong><br>
                        <small class="text-muted">{{ $shipment->receiver_contact }}</small>
                    </td>
                    <td>{{ $shipment->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center">
                        @php
                            $hasResi = !empty($shipment->resi_number) && !empty($shipment->expedition);
                        @endphp
                        <button type="button"
                                class="btn btn-sm {{ $hasResi ? 'btn-success' : 'btn-danger' }} w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#resiModal"
                                data-id="{{ $shipment->id }}"
                                data-resi="{{ $shipment->resi_number }}"
                                data-expedition="{{ $shipment->expedition }}"
                                data-photo="{{ $shipment->resi_photo }}">
                            <i class="fas fa-truck"></i> {{ $hasResi ? 'Update Resi' : 'Isi Resi' }}
                        </button>
                    </td>
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
                                <a href="{{ route('shipments.print', ['shipment' => $shipment, 'size' => 'a5']) }}" class="btn btn-primary" target="_blank">A5</a>
                                <a href="{{ route('shipments.print', ['shipment' => $shipment, 'size' => 'a6']) }}" class="btn btn-primary" target="_blank">A6</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<!-- Modal Form Resi -->
<div class="modal fade" id="resiModal" tabindex="-1" aria-labelledby="resiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resiModalLabel">Detail Resi Pengiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="resiForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="shipment_id" id="shipment_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="resi_number" class="form-label">Nomor Resi</label>
                        <input type="text" class="form-control" id="resi_number" name="resi_number">
                    </div>
                    <div class="mb-3">
                        <label for="expedition" class="form-label">Ekspedisi</label>
                        <select class="form-select" id="expedition" name="expedition">
                            <option value="">Pilih Ekspedisi</option>
                            <option value="JNE">JNE</option>
                            <option value="Pos Indonesia">Pos Indonesia</option>
                            <option value="J&T">J&T Express</option>
                            <option value="SiCepat">SiCepat</option>
                            <option value="AnterAja">AnterAja</option>
                            <option value="TIKI">TIKI</option>
                            <option value="Wahana">Wahana Express</option>
                            <option value="Lion Parcel">Lion Parcel</option>
                            <option value="SAPX">SAPX Express</option>
                            <option value="SPX">SPX Express (Shopee Express)</option>
                            <option value="GoSend">GoSend</option>
                            <option value="GrabExpress">GrabExpress</option>
                            <option value="Ninja Xpress">Ninja Xpress</option>
                            <option value="ID Express">ID Express</option>
                            <option value="DHL">DHL Express</option>
                            <option value="FedEx">FedEx Express</option>
                            <option value="Didi Express">Didi Express</option>
                            <option value="RajaKirim">RajaKirim</option>
                            <option value="Sentral Cargo">Sentral Cargo</option>
                            <option value="Lalamove">Lalamove</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="resi_photo" class="form-label">Foto Resi (opsional)</label>
                        <input type="file" class="form-control" id="resi_photo" name="resi_photo" accept="image/*">
                        <div id="currentPhoto" class="mt-2" style="display:none;">
                            <a href="#" target="_blank" id="photoLink">Lihat foto saat ini</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Saat modal ditampilkan, isi data dari tombol
        $('#resiModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var shipmentId = button.data('id');
            var resiNumber = button.data('resi');
            var expedition = button.data('expedition');
            var photo = button.data('photo');

            var modal = $(this);
            modal.find('#shipment_id').val(shipmentId);
            modal.find('#resi_number').val(resiNumber);
            modal.find('#expedition').val(expedition);
            if (photo) {
                modal.find('#currentPhoto').show();
                modal.find('#photoLink').attr('href', '/storage/' + photo);
            } else {
                modal.find('#currentPhoto').hide();
            }
        });

        // Submit form via AJAX
        $('#resiForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var shipmentId = $('#shipment_id').val();
            var url = '/shipments/' + shipmentId + '/resi';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        location.reload(); // refresh halaman setelah sukses
                    } else {
                        alert('Gagal menyimpan data.');
                    }
                },
                error: function(xhr) {
                    console.log('Error response:', xhr.responseText);
                    alert('Terjadi kesalahan: ' + xhr.status);
                }
            });
        });
    });
</script>
@endpush