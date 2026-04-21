@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-0">
    <h1 class="display-5 fw-bold mb-4">Dashboard</h1>
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card-modern p-3" style="background: linear-gradient(135deg,#3b82f6,#2563eb); color:white;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-white-50">Total Pengiriman</h6>
                        <h2 class="display-4 fw-bold">{{ $totalShipments ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-boxes fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-modern p-3" style="background: linear-gradient(135deg,#10b981,#059669); color:white;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-white-50">Total Paket</h6>
                        <h2 class="display-4 fw-bold">{{ $totalPackages ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-cubes fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-modern p-3" style="background: linear-gradient(135deg,#f59e0b,#d97706); color:white;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-white-50">Resi Belum Lengkap</h6>
                        <h2 class="display-4 fw-bold">{{ $pendingResi ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-truck fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-modern p-3" style="background: linear-gradient(135deg,#8b5cf6,#7c3aed); color:white;">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-white-50">Resi Lengkap</h6>
                        <h2 class="display-4 fw-bold">{{ $completedResi ?? 0 }}</h2>
                    </div>
                    <i class="fas fa-check-circle fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card-modern p-4">
        <h5 class="mb-3"><i class="fas fa-chart-line me-2"></i> Tren Pengiriman 7 Hari Terakhir</h5>
        <canvas id="shipmentChart" height="120"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari controller
    const labels = {!! json_encode($shipmentsPerDay->pluck('date')->map(fn($d) => date('d/m', strtotime($d))) ?? []) !!};
    const data = {!! json_encode($shipmentsPerDay->pluck('total') ?? []) !!};
    new Chart(document.getElementById('shipmentChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pengiriman',
                data: data,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59,130,246,0.1)',
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#2563eb',
                pointRadius: 4
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'top' } } }
    });
</script>
@endpush