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
            font-size: 12px;
            color: #1e293b;
            line-height: 1.5;
        }

        .container { width: 100%; margin: 0 auto; }

        /* ================= KOP SURAT (CLEAN, TANPA KOTAK) ================= */
        .kop { margin-bottom: 15px; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-table td { vertical-align: middle; border: none; padding: 0 5px; }
        .judul-laporan { font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 5px; color: #000000; }
        .periode, .nomor-surat { font-size: 11px; text-align: center; color: #475569; }
        .garis-bawah { border-bottom: 2px solid #0c4a6e; margin: 12px 0 15px 0; }

        /* ================= KETERANGAN (PARAGRAF DENGAN TAB) ================= */
        .keterangan {
            margin: 10px 0 20px 0;
            font-size: 11px;
            text-align: justify;
            line-height: 1.6;
        }
        .keterangan p {
            text-indent: 2em; /* indentasi seperti tab di awal paragraf */
            margin: 0;
        }

        /* ================= TABEL RINGKASAN ================= */
        .summary-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .summary-table td { border: 1px solid #cbd5e1; padding: 12px; text-align: center; background: #f8fafc; }
        .label { font-size: 11px; color: #64748b; margin-bottom: 5px; }
        .value { font-size: 18px; font-weight: bold; }

        /* ================= TABEL RINCIAN ================= */
        h4 { margin: 15px 0 10px 0; font-size: 14px; font-weight: bold; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        th { background: #f1f5f9; border: 1px solid #cbd5e1; padding: 8px; font-size: 11px; font-weight: 600; }
        td { border: 1px solid #cbd5e1; padding: 7px; font-size: 11px; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }

        /* ================= FOOTER ================= */
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }

        @media print { body { margin: 0; padding: 0; } }
    </style>
</head>
<body>
<div class="container">
    <!-- ================= KOP SURAT (CLEAN) ================= -->
    <div class="kop">
        <table class="kop-table">
            <tr>
                <td style="width:22%; text-align:left;">
                    @if(file_exists(public_path('images/danantara.png')))
                        <img src="{{ public_path('images/danantara.png') }}" style="height:33px; width:auto;">
                    @endif
                </td>
                <td style="width:50%; text-align:center;">
                    <div class="judul-laporan">LAPORAN BIAYA PENGIRIMAN</div>
                    <div class="periode">Bulan: {{ $bulan_nama }}</div>
                    <div class="nomor-surat">NO: {{ $nomor_surat }}</div>
                </td>
                <td style="width:28%; text-align:right;">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ public_path('images/logo.png') }}" style="height:45px; width:auto;">
                    @endif
                </td>
            </tr>
        </table>
        <div class="garis-bawah"></div>
    </div>

    <!-- ================= KETERANGAN (DENGAN TAB) ================= -->
    <div class="keterangan">
        <p>Berdasarkan data pengiriman yang tercatat dalam sistem, berikut adalah rincian biaya pengiriman sesuai filter yang dipilih. Laporan ini mencakup total biaya, total berat, serta rincian per cabang tujuan dan per ekspedisi. Data disajikan untuk keperluan evaluasi dan pengambilan keputusan manajemen.</p>
    </div>

    <!-- ================= TABEL RINGKASAN ================= -->
    <table class="summary-table">
        <tr>
            <td><div class="label">Total Pengiriman</div><div class="value">{{ number_format($grandTotalShipments) }}</div></td>
            <td><div class="label">Total Biaya</div><div class="value">Rp {{ number_format($grandTotalCost, 0, ',', '.') }}</div></td>
            <td><div class="label">Total Berat</div><div class="value">{{ number_format($grandTotalWeight, 2) }} kg</div></td>
        </tr>
    </table>

    <!-- ================= TABEL RINCIAN ================= -->
    <h4>Rincian Pengiriman per Cabang &amp; Ekspedisi</h4>
    <table class="data-table">
        <thead>
        <tr>
            <th>Cabang (Kota)</th>
            <th>Ekspedisi</th>
            <th class="text-end">Total Paket</th>
            <th class="text-end">Total Berat (kg)</th>
            <th class="text-end">Total Biaya (Rp)</th>
        </tr>
        </thead>
        <tbody>
        @forelse($detailStats as $row)
        <tr>
            <td>{{ $row->receiver_city }}</td>
            <td>{{ $row->expedition }}</td>
            <td class="text-end">{{ number_format($row->total_paket) }}</td>
            <td class="text-end">{{ number_format($row->total_berat, 2) }}</td>
            <td class="text-end">Rp {{ number_format($row->total_biaya, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">Tidak ada data untuk filter yang dipilih.</td>
        </tr>
        @endforelse
        </tbody>
    </table>

    <!-- ================= FOOTER ================= -->
    <div class="footer">
        Dicetak: {{ now()->format('d/m/Y H:i:s') }} |
        Sistem Manajemen Pengiriman Barang - PT Pelita Indonesia Djaya
    </div>
</div>
</body>
</html>