@extends('layouts.app')

@section('title', 'Laporan Pengiriman per Bulan')

@section('content')
<div class="container-fluid px-0">
    <h1 class="display-5 fw-bold mb-4">Laporan Pengiriman per Bulan</h1>

    <!-- Filter Tahun -->
    <div class="card-modern p-3 mb-4">
        <form method="GET" action="{{ route('laporan') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Pilih Tahun</label>
                <select name="tahun" class="form-select">
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ (request('tahun', date('Y')) == $y) ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            @if(request('tahun'))
            <div class="col-md-2">
                <a href="{{ route('laporan') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
            @endif
        </form>
    </div>

    @if($shipments->isEmpty())
        <div class="card-modern text-center p-5">Belum ada data untuk tahun {{ request('tahun', date('Y')) }}.</div>
    @else

        <!-- Tabel Data -->
        <div class="card-modern p-4">
            <h5 class="mb-3"><i class="fas fa-table"></i> Tabel Pengiriman per Bulan</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Bulan</th>
                            <th class="text-end">Jumlah Pengiriman</th>
                            <th class="text-end">Total Paket</th>
                            <th class="text-end">Total Berat (kg)</th>
                            <th class="text-end">Total Biaya (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalShipments = 0;
                            $totalPackages = 0;
                            $totalWeight = 0;
                            $totalCost = 0;
                        @endphp
                        @foreach($shipments as $s)
                        @php
                            $totalShipments += $s->total_shipments;
                            $totalPackages += $s->total_packages;
                            $totalWeight += $s->total_weight;
                            $totalCost += $s->total_cost;
                        @endphp
                        <tr>
                            <td>{{ $s->bulan_nama }} ({{ $s->bulan }})</td>
                            <td class="text-end">{{ number_format($s->total_shipments) }}</td>
                            <td class="text-end">{{ number_format($s->total_packages) }}</td>
                            <td class="text-end">{{ number_format($s->total_weight, 2) }}</td>
                            <td class="text-end">Rp {{ number_format($s->total_cost, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-light fw-bold">
                        <tr>
                            <th>Total {{ request('tahun', date('Y')) }}</th>
                            <th class="text-end">{{ number_format($totalShipments) }}</th>
                            <th class="text-end">{{ number_format($totalPackages) }}</th>
                            <th class="text-end">{{ number_format($totalWeight, 2) }}</th>
                            <th class="text-end">Rp {{ number_format($totalCost, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Grafik Batang -->
        <div class="card-modern p-4 mb-5">
            <h5 class="mb-3"><i class="fas fa-chart-bar text-primary"></i> Grafik Pengiriman per Bulan</h5>
            <canvas id="monthlyChart" height="120"></canvas>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const chartData = {!! json_encode($shipments->map(function($s) { return $s->total_shipments; })) !!};
    const chartLabels = {!! json_encode($shipments->map(function($s) { return $s->bulan_nama; })) !!};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Pengiriman',
                data: chartData,
                backgroundColor: '#3b82f6',
                borderRadius: 8,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: { callbacks: { label: (ctx) => `${ctx.raw} pengiriman` } }
            },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Jumlah Pengiriman' } },
                x: { title: { display: true, text: 'Bulan' } }
            }
        }
    });
</script>
@endpush