@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid px-0">
    <h1 class="display-5 fw-bold mb-4">Dashboard</h1>

    <!-- Statistik Utama (tetap seperti sebelumnya) -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card-modern p-3" style="background: linear-gradient(135deg,#3b82f6,#2563eb); color:white;">
                <div class="d-flex justify-content-between">
                    <div><h6 class="text-white-50">Total Pengiriman</h6><h2 class="display-4 fw-bold">{{ $totalShipments ?? 0 }}</h2></div>
                    <i class="fas fa-boxes fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-modern p-3" style="background: linear-gradient(135deg,#10b981,#059669); color:white;">
                <div class="d-flex justify-content-between">
                    <div><h6 class="text-white-50">Total Paket</h6><h2 class="display-4 fw-bold">{{ $totalPackages ?? 0 }}</h2></div>
                    <i class="fas fa-cubes fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-modern p-3" style="background: linear-gradient(135deg,#f59e0b,#d97706); color:white;">
                <div class="d-flex justify-content-between">
                    <div><h6 class="text-white-50">Resi Belum Lengkap</h6><h2 class="display-4 fw-bold">{{ $pendingResi ?? 0 }}</h2></div>
                    <i class="fas fa-truck fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-modern p-3" style="background: linear-gradient(135deg,#8b5cf6,#7c3aed); color:white;">
                <div class="d-flex justify-content-between">
                    <div><h6 class="text-white-50">Resi Lengkap</h6><h2 class="display-4 fw-bold">{{ $completedResi ?? 0 }}</h2></div>
                    <i class="fas fa-check-circle fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Cabang & Ekspedisi + Daftar Pengiriman Terbaru -->
    <div class="row g-4">
        <!-- Kiri: Top 5 Cabang -->
        <div class="col-md-4">
            <div class="card-modern p-4 h-100">
                <h5 class="mb-3"><i class="fas fa-map-marker-alt text-primary"></i> Top 5 Cabang Tujuan</h5>
                @if(isset($topCities) && count($topCities))
                    <div class="list-group list-group-flush">
                        @foreach($topCities as $city)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>{{ $city->receiver_city }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $city->total }} pengiriman</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Belum ada data cabang.</p>
                @endif
            </div>
        </div>

        <!-- Kanan: Top Ekspedisi -->
        <div class="col-md-4">
            <div class="card-modern p-4 h-100">
                <h5 class="mb-3"><i class="fas fa-truck-moving text-success"></i> Ekspedisi Paling Sering Digunakan</h5>
                @if(isset($topExpeditions) && count($topExpeditions))
                    <div class="list-group list-group-flush">
                        @foreach($topExpeditions as $exp)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>{{ $exp->expedition ?? 'Tidak diketahui' }}</span>
                            <span class="badge bg-info rounded-pill">{{ $exp->total }} kali</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Belum ada data ekspedisi.</p>
                @endif
            </div>
        </div>

        <!-- Tambahan: Pengiriman Terbaru -->
        <div class="col-md-4">
            <div class="card-modern p-4 h-100">
                <h5 class="mb-3"><i class="fas fa-clock text-warning"></i> Pengiriman Terbaru</h5>
                @if(isset($recentShipments) && count($recentShipments))
                    <div class="list-group list-group-flush">
                        @foreach($recentShipments as $ship)
                        <div class="list-group-item px-0">
                            <div class="fw-bold">{{ $ship->receiver_city }}</div>
                            <small class="text-muted">{{ $ship->created_at->diffForHumans() }} • {{ $ship->receiver_name }}</small>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Belum ada pengiriman.</p>
                @endif
            </div>
        </div>
        <!-- Grafik Tren Pengiriman (tetap) -->
        <div class="card-modern p-4 mb-5">
            <h5 class="mb-3"><i class="fas fa-chart-line me-2"></i> Tren Pengiriman 7 Hari Terakhir</h5>
            <canvas id="shipmentChart" height="100"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('shipmentChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($shipmentsPerDay->pluck('date')->map(fn($d)=>date('d/m',strtotime($d))) ?? []) !!},
            datasets: [{
                label: 'Jumlah Pengiriman',
                data: {!! json_encode($shipmentsPerDay->pluck('total') ?? []) !!},
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