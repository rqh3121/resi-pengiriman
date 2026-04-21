<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Biaya Pengiriman</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
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
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 8px;
            color: #0f172a;
        }
        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #475569;
            margin-bottom: 24px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 16px;
        }
        /* Tabel ringkasan horizontal */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px;
        }
        .summary-table td {
            border: 1px solid #cbd5e1;
            padding: 12px 16px;
            text-align: center;
            background-color: #f8fafc;
        }
        .summary-table .label {
            font-size: 12px;
            color: #475569;
            display: block;
            margin-bottom: 6px;
        }
        .summary-table .value {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
        }
        /* Tabel data utama */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        th {
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #1e293b;
        }
        td {
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
            font-size: 12px;
            vertical-align: top;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 32px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 16px;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Biaya Pengiriman</h1>
        <div class="subtitle">
            Periode: {{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }}
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
                    <th class="text-end">Rata-rata per Kiriman (Rp)</th>
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