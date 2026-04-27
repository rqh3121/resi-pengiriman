@extends('layouts.app')

@section('title', 'Daftar Pengiriman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="display-5 fw-bold">Daftar Pengiriman</h1>
    <a href="{{ route('shipments.create') }}" class="btn btn-primary btn-modern"><i class="fas fa-plus-circle me-2"></i> Tambah Baru</a>
</div>

<!-- Filter Proyek -->
<form method="GET" class="mb-4">
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Filter Proyek</label>
            <select name="project_id" class="form-select">
                <option value="">Semua Proyek</option>
                @foreach(\App\Models\Project::orderBy('judul_proyek')->get() as $proj)
                    <option value="{{ $proj->id }}" {{ request('project_id') == $proj->id ? 'selected' : '' }}>{{ $proj->judul_proyek }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
        @if(request('project_id'))
            <div class="col-md-2 align-self-end">
                <a href="{{ route('shipments.index') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        @endif
    </div>
</form>

<!-- Search form -->
<form method="GET" class="mb-4">
    <div class="input-group shadow-sm rounded-4 overflow-hidden">
        <input type="text" name="search" class="form-control border-0 py-2" placeholder="Cari pengirim, penerima, atau kota..." value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
        @if(request('search')) <a href="{{ route('shipments.index', request('project_id') ? ['project_id' => request('project_id')] : []) }}" class="btn btn-secondary">Reset</a> @endif
    </div>
</form>

@if($shipments->isEmpty())
    <div class="card-modern text-center p-5">Belum ada data.</div>
@else
    <div class="card-modern overflow-hidden p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Proyek</th>
                        <th>Pengirim</th>
                        <th>Penerima</th>
                        <th>Kota Tujuan</th>
                        <th class="text-center">Jumlah Paket</th>
                        <th>Tanggal</th>
                        <th class="text-center">Resi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shipments as $index => $s)
                    <tr>
                        <td class="fw-bold">{{ $index + 1 }}</td>
                        <td>{{ $s->project->judul_proyek ?? '-' }}</td>
                        <td><strong>{{ $s->sender_name }}</strong><br><small class="text-muted">{{ $s->sender_contact }}</small></td>
                        <td><strong>{{ $s->receiver_name }}</strong><br><small class="text-muted">{{ $s->receiver_contact }}</small></td>
                        <td>{{ $s->receiver_city }}</td>
                        <td class="text-center"><span class="badge bg-info rounded-pill px-3 py-2">{{ $s->package_count }}</span></td>
                        <td>{{ $s->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            @php $hasResi = !empty($s->resi_number) && !empty($s->expedition); @endphp
                            <button class="btn btn-sm {{ $hasResi ? 'btn-success' : 'btn-danger' }} rounded-pill px-3" 
                                data-bs-toggle="modal" data-bs-target="#resiModal"
                                data-id="{{ $s->id }}" 
                                data-resi="{{ $s->resi_number }}"
                                data-expedition="{{ $s->expedition }}" 
                                data-photo="{{ $s->resi_photo }}"
                                data-weight="{{ $s->weight }}"
                                data-cost="{{ $s->shipping_cost }}">
                                <i class="fas fa-truck"></i> {{ $hasResi ? 'Update Resi' : 'Isi Resi' }}
                            </button>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('shipments.show', $s) }}" class="btn btn-sm btn-info rounded-circle"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('shipments.edit', $s) }}" class="btn btn-sm btn-warning rounded-circle"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('shipments.destroy', $s) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-circle" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></button>
                                </form>
                                <div class="btn-group">
                                    <a href="{{ route('shipments.print', [$s, 'a4']) }}" class="btn btn-sm btn-primary rounded-pill" target="_blank">A4</a>
                                    <a href="{{ route('shipments.print', [$s, 'a5']) }}" class="btn btn-sm btn-primary rounded-pill" target="_blank">A5</a>
                                    <a href="{{ route('shipments.print', [$s, 'a6']) }}" class="btn btn-sm btn-primary rounded-pill" target="_blank">A6</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<!-- MODAL RESI (sama seperti sebelumnya) -->
<div class="modal fade" id="resiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                <h5 class="modal-title"><i class="fas fa-truck"></i> Detail Resi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="resiForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="shipment_id" id="shipment_id">
                <div class="modal-body p-4">
                    <div class="mb-3"><label>Nomor Resi</label><input type="text" name="resi_number" id="resi_number" class="form-control"></div>
                    <div class="mb-3"><label>Ekspedisi</label>
                        <select name="expedition" id="expedition" class="form-select">
                            <option value="">Pilih</option>
                            <option value="JNE">JNE</option><option value="Pos Indonesia">Pos Indonesia</option>
                            <option value="J&T">J&T</option><option value="SiCepat">SiCepat</option>
                            <option value="AnterAja">AnterAja</option><option value="TIKI">TIKI</option>
                            <option value="Wahana">Wahana</option><option value="Lion Parcel">Lion Parcel</option>
                            <option value="SAPX">SAPX</option><option value="SPX">SPX</option>
                            <option value="GoSend">GoSend</option><option value="GrabExpress">GrabExpress</option>
                            <option value="Ninja Xpress">Ninja Xpress</option><option value="ID Express">ID Express</option>
                            <option value="DHL">DHL</option><option value="FedEx">FedEx</option>
                            <option value="Didi Express">Didi Express</option><option value="RajaKirim">RajaKirim</option>
                            <option value="Sentral Cargo">Sentral Cargo</option><option value="Lalamove">Lalamove</option>
                        </select>
                    </div>
                    <div class="mb-3"><label>Berat (kg)</label><input type="number" step="0.01" class="form-control" name="weight" id="weight"></div>
                    <div class="mb-3"><label>Biaya Pengiriman (Rp)</label><input type="number" step="1000" class="form-control" name="shipping_cost" id="shipping_cost"></div>
                    <div class="mb-3"><label>Foto Resi</label><input type="file" name="resi_photo" class="form-control" accept="image/*"></div>
                    <div id="currentPhoto" class="d-none"><a href="#" target="_blank" id="photoLink">Lihat foto</a></div>
                </div>
                <div class="modal-footer border-0"><button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button></div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#resiModal').on('show.bs.modal', function(e) {
        let btn = $(e.relatedTarget);
        let modal = $(this);
        modal.find('#shipment_id').val(btn.data('id'));
        modal.find('#resi_number').val(btn.data('resi'));
        modal.find('#expedition').val(btn.data('expedition'));
        modal.find('#weight').val(btn.data('weight'));
        modal.find('#shipping_cost').val(btn.data('cost'));
        let photo = btn.data('photo');
        if (photo) {
            modal.find('#currentPhoto').removeClass('d-none').find('#photoLink').attr('href', '/storage/' + photo);
        } else {
            modal.find('#currentPhoto').addClass('d-none');
        }
    });

    $('#resiForm').on('submit', function(e) {
        e.preventDefault();
        let fd = new FormData(this);
        let id = $('#shipment_id').val();
        $.ajax({
            url: '/shipments/' + id + '/resi',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(res) { if (res.success) location.reload(); else alert('Gagal'); },
            error: function(xhr) { alert('Error: ' + xhr.status); }
        });
    });
</script>
@endpush