@extends('layouts.app')
@section('title', 'Laporan Pengiriman')
@section('content')
<div class="card-modern p-4"><h2 class="mb-4"><i class="fas fa-chart-bar me-2"></i> Laporan Pengiriman per Bulan</h2>
<div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Tahun</th><th>Bulan</th><th>Jumlah Pengiriman</th></tr></thead><tbody>@foreach($shipments as $s)<tr><td>{{ $s->tahun }}</td><td>{{ date('F', mktime(0,0,0,$s->bulan,1)) }} ({{ $s->bulan }})</td><td>{{ $s->total }}</td></tr>@endforeach</tbody></table></div></div>
@endsection