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
        /* Tabel utama (dua kolom) dengan border putus-putus */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px dashed #aaa;
        }
        .left-col {
            width: 35%;
            vertical-align: middle;
            text-align: center;
            border-right: 2px dashed #aaa;
            padding: 12px;
        }
        .right-col {
            width: 65%;
            vertical-align: top;
            padding: 12px;
        }
        /* Logo besar */
        .logo img {
            max-width: 180px;
            height: auto;
        }
        /* Tabel untuk 4 simbol dengan border putus-putus */
        .symbol-table {
            width: 100%;
            margin: 15px 0;
            border-collapse: collapse;
            border: 1px dashed #aaa;
        }
        .symbol-table td {
            text-align: center;
            padding: 8px;
            border: 1px dashed #aaa;
        }
        .symbol-table img {
            max-width: 120px;
            height: auto;
        }
        .thankyou {
            text-align: center;
            font-style: italic;
            font-size: 12px;
            color: #555;
            margin: 10px 0 5px;
        }
        /* Tanggal di bawah Thank You! dengan garis putus-putus di bawahnya */
        .footer-date {
            text-align: right;
            font-size: 10px;
            color: #666;
            margin-top: 5px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #ccc;
        }
        /* SENDER dan SHIP TO */
        .sender-box {
            margin-bottom: 20px;
        }
        .sender-box .label {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .sender-info {
            font-size: 11px;
            line-height: 1.4;
        }
        .shipto-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 6px;
        }
        .receiver-name {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
        }
        .receiver-details {
            font-size: 11px;
            line-height: 1.4;
        }
        /* Responsif A5 */
        @media (max-width: 148mm) {
            .left-col, .right-col { padding: 8px; }
            .logo img { max-width: 140px; }
            .symbol-table img { max-width: 90px; }
            .thankyou { font-size: 10px; }
            .shipto-title { font-size: 16px; }
            .receiver-name { font-size: 14px; }
            .sender-info, .receiver-details { font-size: 10px; }
            .footer-date { font-size: 9px; }
        }
        /* Responsif A6 */
        @media (max-width: 105mm) {
            .left-col, .right-col { padding: 5px; }
            .logo img { max-width: 100px; }
            .symbol-table img { max-width: 70px; }
            .thankyou { font-size: 8px; }
            .shipto-title { font-size: 13px; }
            .receiver-name { font-size: 12px; }
            .sender-info, .receiver-details { font-size: 9px; }
            .footer-date { font-size: 8px; }
            .symbol-table td { padding: 4px; }
        }
    </style>
</head>
<body>
    <!-- Tabel utama (logo kiri, info kanan) -->
    <table class="main-table">
        <tr>
            <td class="left-col">
                <div class="logo">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
                    @endif
                </div>
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
    </table>

    <!-- Tabel untuk 4 simbol dengan border putus-putus -->
    <table class="symbol-table">
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

    <div class="thankyou">Thank You!</div>

    <div class="footer-date">
        Tanggal: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>