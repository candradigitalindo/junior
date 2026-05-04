<html>
<head>
    <title>INVOICE #{{ $transaksi->invoice }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 10pt;
            margin: 10px;
            width: 76mm; /* Standard thermal paper width */
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .mb-1 { margin-bottom: 4px; }
        .mt-1 { margin-top: 4px; }
        .divider { border-top: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; border-collapse: collapse; }
        .item-table td { vertical-align: top; padding: 2px 0; }
        .qrcode { margin: 10px 0; }
        .footer { font-size: 8pt; margin-top: 15px; }
    </style>
</head>
<body>
    @php
        // Dynamic address mapping based on login username
        $addressMap = [
            'superadmin' => 'Jl. Perjuangan No.23, Medan',
            'kasir'      => 'Jl. Perjuangan No.23, Medan',
            'loket'      => 'Jl. Perjuangan No.23, Medan'
        ];
        $currentAddress = $addressMap[auth()->user()->username] ?? 'Jl. Perjuangan No.23, Kota Medan';
    @endphp

    <div class="text-center">
        <div class="fw-bold" style="font-size: 13pt; letter-spacing: 1px;">JUNIOR PREMIUM AUTO CARE</div>
        <div class="mt-1" style="font-size: 9pt;">{{ $currentAddress }}</div>
        <div style="font-size: 9pt;">WhatsApp: 081367717172</div>
    </div>

    <div class="divider"></div>

    <table>
        <tr>
            <td width="35%">Invoice</td>
            <td>: #{{ $transaksi->invoice }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{ date('d/m/Y H:i', strtotime($transaksi->created_at)) }}</td>
        </tr>
        <tr>
            <td>No. Pol</td>
            <td>: <span class="fw-bold">{{ $booking->no_pol_kendaraan }}</span></td>
        </tr>
        <tr>
            <td>Tipe</td>
            <td>: {{ $booking->tipe_mobil }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td>: {{ auth()->user()->name }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table class="item-table">
        @foreach ($booking->bookingorder as $item)
            <tr>
                <td class="fw-bold" style="width: 65%;">{{ $item->product_name }}</td>
                <td class="text-right" style="width: 35%;">{{ number_format($item->product_price, 0, ',', '.') }}</td>
            </tr>
            @if ($item->extraservice_price > 0)
                <tr>
                    <td style="padding-left: 10px; width: 65%; font-size: 9pt;">+ {{ $item->extraservice_name }}</td>
                    <td class="text-right" style="width: 35%; font-size: 9pt;">{{ number_format($item->extraservice_price, 0, ',', '.') }}</td>
                </tr>
            @endif
        @endforeach
    </table>

    <div class="divider"></div>

    <table>
        @if ($transaksi->discount > 0)
            <tr>
                <td class="text-right">Subtotal :</td>
                <td class="text-right" width="40%">{{ number_format($transaksi->total + $transaksi->discount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-right">Diskon :</td>
                <td class="text-right">-{{ number_format($transaksi->discount, 0, ',', '.') }}</td>
            </tr>
        @endif
        <tr>
            <td class="text-right fw-bold" style="font-size: 12pt;">TOTAL :</td>
            <td class="text-right fw-bold" style="font-size: 12pt;">{{ number_format($transaksi->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-right mt-1">Metode :</td>
            <td class="text-right mt-1">{{ $transaksi->metode_pembayaran ?: 'Tunai' }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="text-center qrcode">
        <div style="display: inline-block; padding: 5px; border: 1px dashed #ccc;">
            {!! $qrcode !!}
        </div>
    </div>

    <div class="text-center footer">
        <div class="fw-bold">***** TERIMA KASIH *****</div>
        <div class="mt-1">Kritik & Saran Hubungi WhatsApp Kami</div>
        <div>Simpan struk ini sebagai bukti pembayaran sah.</div>
    </div>
</body>
</html>


