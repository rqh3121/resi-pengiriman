<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Label Pengiriman #{{ $shipment->id }}</title>
    <style>
        @page {
            size: {{ $paper['width'] }} {{ $paper['height'] }};
            margin: 0.3cm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        /* Tabel utama (dua kolom) */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px dashed #aaa;
        }
        .left-col {
            width: 35%;
            vertical-align: middle;     /* tengah vertikal */
            text-align: center;         /* tengah horizontal */
            border-right: 2px dashed #aaa;
            padding: 8px;
        }
        .right-col {
            width: 65%;
            vertical-align: top;
            padding: 8px;
        }
        /* Logo */
        .logo img {
            max-width: 160px;
            height: auto;
            margin-bottom: 2px;         /* kecilkan jarak bawah agar package naik */
        }
        /* Tabel package (nomor halaman) */
        .package-table {
            width: 80%;
            margin: 0 auto 0;            /* margin-top 0 agar lebih naik */
            border-collapse: collapse;
            border: 1px dashed #aaa;
        }
        .package-table td {
            padding: 6px 12px;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
        }
        /* Tabel 4 simbol */
        .symbol-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px dashed #aaa;
        }
        .symbol-table td {
            text-align: center;
            padding: 6px;
            border: 1px dashed #aaa;
        }
        .symbol-table img {
            max-width: 100px;
            height: auto;
        }
        /* Baris untuk Thank You dan tanggal (dalam tabel utama) */
        .thankyou-date-row td {
            border-top: 1px dashed #ccc;
            padding: 6px 12px;
        }
        .thankyou {
            text-align: center;
            font-style: italic;
            font-size: 12px;
            color: #555;
        }
        .date-cell {
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        /* SENDER dan SHIP TO */
        .sender-box {
            margin-bottom: 12px;
        }
        .sender-box .label {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .sender-info {
            font-size: 11px;
            line-height: 1.3;
        }
        .shipto-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .receiver-name {
            font-size: 14px;
            font-weight: bold;
            margin: 3px 0;
        }
        .receiver-details {
            font-size: 11px;
            line-height: 1.3;
        }
        .page-break {
            page-break-after: always;
        }
        /* Responsif A5 */
        @media (max-width: 148mm) {
            .left-col, .right-col { padding: 5px; }
            .logo img { max-width: 120px; margin-bottom: 1px; }
            .package-table td { font-size: 22px; padding: 4px 8px; }
            .symbol-table img { max-width: 70px; }
            .symbol-table td { padding: 4px; }
            .thankyou { font-size: 10px; }
            .date-cell { font-size: 8px; }
            .shipto-title { font-size: 14px; }
            .receiver-name { font-size: 12px; }
            .sender-info, .receiver-details { font-size: 9px; }
        }
        /* Responsif A6 */
        @media (max-width: 105mm) {
            .left-col, .right-col { padding: 4px; }
            .logo img { max-width: 90px; margin-bottom: 1px; }
            .package-table td { font-size: 18px; padding: 3px 6px; }
            .symbol-table img { max-width: 55px; }
            .symbol-table td { padding: 3px; }
            .thankyou { font-size: 8px; }
            .date-cell { font-size: 7px; }
            .shipto-title { font-size: 12px; }
            .receiver-name { font-size: 11px; }
            .sender-info, .receiver-details { font-size: 8px; }
        }
    </style>
</head>
<body>
    @for ($i = 1; $i <= $totalPages; $i++)
        <div class="label">
            <table class="main-table">
                <!-- Baris pertama: kiri (logo & package) + kanan (sender & ship to) -->
                 <tr>
                    <td class="left-col">
                        <div class="logo">
                            @if(file_exists(public_path('images/logo.png')))
                                <img src="{{ public_path('images/logo.png') }}" alt="Logo">
                            @endif
                        </div>
                        @if($totalPages > 1)
                            <table class="package-table">
                                 <tr>
                                     <td>{{ $i }}/{{ $totalPages }}</td>
                                 </tr>
                              </table>
                        @endif
                    </td>
                    <td class="right-col">
                        <div class="sender-box">
                            <div class="label">SENDER:</div>
                            <div class="sender-info">
                                <strong>{{ strtoupper($shipment->sender_name) }}</strong><br>
                                {{ $shipment->sender_contact }}<br>
                                {{ strtoupper($shipment->sender_address) }}
                            </div>
                        </div>
                        <div>
                            <div class="shipto-title">SHIP TO:</div>
                            <div class="receiver-name">
                                {{ strtoupper($shipment->receiver_name) }}
                                <span style="color: red; font-weight: bold;">({{ strtoupper($shipment->receiver_city) }})</span>
                            </div>
                            <div class="receiver-details">
                                {{ $shipment->receiver_contact }}<br>
                                {{ strtoupper($shipment->receiver_address) }}
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- Baris kedua: 4 simbol (menggabungkan dua kolom) -->
                <tr>
                    <td colspan="2" style="padding: 0;">
                        <table class="symbol-table" style="width: 100%; border: none;">
                            <tr>
                                <td>
                                    @if(file_exists(public_path('images/care.png')))
                                        <img src="{{ public_path('images/care.png') }}" alt="Care">
                                    @endif
                                </td>
                                <td>
                                    @if(file_exists(public_path('images/pecah.png')))
                                        <img src="{{ public_path('images/pecah.png') }}" alt="Pecah">
                                    @endif
                                </td>
                                <td>
                                    @if(file_exists(public_path('images/keepdray.png')))
                                        <img src="{{ public_path('images/keepdray.png') }}" alt="Keep Dry">
                                    @endif
                                </td>
                                <td>
                                    @if(file_exists(public_path('images/injak.png')))
                                        <img src="{{ public_path('images/injak.png') }}" alt="Injak">
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Baris ketiga: Thank You! dan tanggal dalam satu baris (dua kolom) -->
                <tr class="thankyou-date-row">
                    <td colspan="2" style="padding: 6px 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div class="thankyou">Thank You!</div>
                            <div class="date-cell">Tanggal: {{ now()->format('d/m/Y H:i') }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        @if ($i < $totalPages)
            <div class="page-break"></div>
        @endif
    @endfor
</body>
</html>