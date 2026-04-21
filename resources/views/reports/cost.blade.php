@extends('layouts.app')

@section('title', 'Laporan Biaya Pengiriman')

@section('content')
<div class="container-fluid px-0">
    <h1 class="display-5 fw-bold mb-4">Laporan Biaya Pengiriman</h1>

    <!-- Form Filter -->
    <div class="card-modern p-3 mb-4">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Bulan</label>
                <select name="month" class="form-select">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$i,1)) }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tahun</label>
                <select name="year" class="form-select">
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>

    <!-- Ringkasan Kartu -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card-modern p-3 text-center bg-light">
                <h6 class="text-muted">Total Pengiriman</h6>
                <h2 class="fw-bold">{{ number_format($grandTotalShipments) }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-modern p-3 text-center bg-light">
                <h6 class="text-muted">Total Biaya</h6>
                <h2 class="fw-bold text-success">Rp {{ number_format($grandTotalCost, 0, ',', '.') }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-modern p-3 text-center bg-light">
                <h6 class="text-muted">Total Berat</h6>
                <h2 class="fw-bold">{{ number_format($grandTotalWeight, 2) }} kg</h2>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card-modern p-4">
        <h5 class="mb-3"><i class="fas fa-table"></i> Rincian per Ekspedisi</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Ekspedisi</th>
                        <th class="text-end">Jumlah Kiriman</th>
                        <th class="text-end">Total Berat (kg)</th>
                        <th class="text-end">Total Biaya (Rp)</th>
                        <th class="text-end">Rata-rata per Kiriman (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $row)
                    <tr>
                        <td><strong>{{ $row->expedition }}</strong></td>
                        <td class="text-end">{{ number_format($row->total_shipments) }}</td>
                        <td class="text-end">{{ number_format($row->total_weight, 2) }}</td>
                        <td class="text-end">Rp {{ number_format($row->total_cost, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($row->avg_cost_per_shipment, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data untuk periode yang dipilih.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

        <!-- Grafik -->
    <div class="card-modern p-4 mb-5">
        <h5 class="mb-3"><i class="fas fa-chart-pie"></i> Perbandingan Biaya per Ekspedisi</h5>
        <div class="row">
            <div class="col-md-6">
                <div style="max-width: 280px; margin: 0 auto;">
                    <canvas id="costChart" height="180"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div style="max-width: 280px; margin: 0 auto;">
                    <canvas id="shipmentChart" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>


    <!-- Tombol Ekspor -->
    <div class="mb-4">
        <a href="{{ route('reports.cost.export.excel', ['month' => $month, 'year' => $year]) }}" 
        class="btn btn-success btn-modern me-2">
            <i class="fas fa-file-excel me-1"></i> Ekspor ke Excel
        </a>
        <a href="{{ route('reports.cost.export.pdf', ['month' => $month, 'year' => $year]) }}" 
        class="btn btn-danger btn-modern">
            <i class="fas fa-file-pdf me-1"></i> Ekspor ke PDF
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik biaya (pie chart)
    const ctxCost = document.getElementById('costChart').getContext('2d');
    new Chart(ctxCost, {
        type: 'pie',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Total Biaya (Rp)',
                data: {!! json_encode($costs) !!},
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec489a', '#06b6d4', '#84cc16'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'right' },
                tooltip: { callbacks: { label: (ctx) => `Rp ${ctx.raw.toLocaleString('id-ID')}` } }
            }
        }
    });

    // Grafik jumlah kiriman (bar chart)
    const ctxShip = document.getElementById('shipmentChart').getContext('2d');
    new Chart(ctxShip, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Jumlah Kiriman',
                data: {!! json_encode($shipments) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } }
        }
    });
</script>
@endpush