<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Biaya Pengiriman</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background: white;
            padding: 20px;
            color: #1e293b;
        }
        .container {
            max-width: 100%;
            margin: 0 auto;
        }
        /* Kop surat */
        .kop {
            margin-bottom: 20px;
            border-bottom: 2px solid #0c4a6e;
            padding-bottom: 15px;
        }
        .kop-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }
        .logo-left {
            flex: 1;
            text-align: left;
        }
        .logo-left img {
            max-height: 55px;
            max-width: 180px;
            width: auto;
            height: auto;
            object-fit: contain;
        }
        .kop-text {
            flex: 2;
            text-align: center;
        }
        .logo-right {
            flex: 1;
            text-align: right;
        }
        .logo-right img {
            max-height: 55px;
            max-width: 180px;
            width: auto;
            height: auto;
            object-fit: contain;
        }
        .judul-laporan {
            font-size: 18px;
            font-weight: bold;
            color: #0c4a6e;
            margin-bottom: 5px;
        }
        .periode {
            font-size: 12px;
            color: #475569;
        }
        /* Tabel ringkasan (horizontal) */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .summary-table td {
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            text-align: center;
            background-color: #f8fafc;
        }
        .summary-table .label {
            font-size: 11px;
            color: #475569;
            display: block;
            margin-bottom: 5px;
        }
        .summary-table .value {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
        }
        /* Tabel data utama */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #1e293b;
        }
        td {
            border: 1px solid #cbd5e1;
            padding: 6px 10px;
            font-size: 11px;
            vertical-align: top;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
        }
        @media print {
            body { padding: 0; margin: 0; }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Kop surat dengan dua logo -->
    <div class="kop">
        <div class="kop-row">
            <div class="logo-left">
                <img src="{{ public_path('images/danantara.png') }}" alt="Danantara Logo">
            </div>
            <div class="kop-text">
                <div class="judul-laporan">LAPORAN BIAYA PENGIRIMAN</div>
                <div class="periode">Periode: {{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }}</div>
            </div>
            <div class="logo-right">
                <img src="{{ public_path('images/logo.png') }}" alt="Company Logo">
            </div>
        </div>
    </div>

    <!-- Tabel ringkasan (horizontal) -->
    <table class="summary-table">
        <tr>
            <td>
                <div class="label">Total Pengiriman</div>
                <div class="value">{{ number_format($grandTotalShipments) }}</div>
            </td>
            <td>
                <div class="label">Total Biaya</div>
                <div class="value">Rp {{ number_format($grandTotalCost, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Total Berat</div>
                <div class="value">{{ number_format($grandTotalWeight, 2) }} kg</div>
            </td>
        </tr>
    </table>

    <!-- Tabel data per ekspedisi -->
    <table class="data-table">
        <thead>
        <tr>
            <th>Ekspedisi</th>
            <th class="text-end">Jumlah Kiriman</th>
            <th class="text-end">Total Berat (kg)</th>
            <th class="text-end">Total Biaya (Rp)</th>
            <th class="text-end">Rata‑rata per Kiriman (Rp)</th>
        </tr>
        </thead>
        <tbody>
        @forelse($reportData as $row)
            <tr>
                <td>{{ $row->expedition }}</td>
                <td class="text-end">{{ number_format($row->total_shipments) }}</td>
                <td class="text-end">{{ number_format($row->total_weight, 2) }}</td>
                <td class="text-end">Rp {{ number_format($row->total_cost, 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($row->avg_cost_per_shipment, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data untuk periode yang dipilih.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }} | Sistem Manajemen Pengiriman Barang - PT Pelita Indonesia Djaya
    </div>
</div>
</body>
</html>