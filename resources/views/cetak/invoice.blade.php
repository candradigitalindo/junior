


<html>

<head>
    <title>INVOICE #{{ $transaksi->invoice }}</title>
    <style>
        #tabel {
            font-size: 15px;
            border-collapse: collapse;
        }

        #tabel td {
            padding-left: 1px;
            border: 1px solid black;
        }
    </style>
</head>

<body style='font-family:tahoma; font-size:8pt;'>
    <center>

        <table style='width:210px; font-size:16pt; font-family:calibri; border-collapse: collapse;' border='0'>
            <tr>
                <td width='70%' align='CENTER' vertical-align:top'><span style='color:black;'>
                    <img src="{{ public_path('image/no_photo_tipe_mobil.png') }}"
                                    style="width: 100px; max-width: 300px" />
            </td>
            </tr>
            <td width='70%' align='CENTER' vertical-align:top'><span style='color:black;'>
                    <b>JUNIOR Premium Car Wash </b><br><span style='font-size:12pt'>Alamat : -</span>
                <br><span style='font-size:12pt'>WhatsApp 0821 XXXX XXXX</span>
            </td>

        </table>

        <style>
            hr {
                display: block;
                margin-top: 0.5em;
                margin-bottom: 0.5em;
                margin-left: auto;
                margin-right: auto;
                border-style: inset;
                border-width: 1px;
            }
        </style>
        <br>
        <table cellspacing='0' cellpadding='0'style='width:200px; font-size:12pt; font-family:calibri;  border-collapse: collapse;' border='0'>
            <tr>
                <td>Invoice</td>
                <td>:</td>
                <td>{{ $transaksi->invoice }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ date('d-m-Y H:i', strtotime($transaksi->created_at)) }} </td>
            </tr>
            <tr>
                <td>No</td>
                <td>:</td>
                <td>{{ $booking->no_pol_kendaraan }}</td>
            </tr>
            <tr>
                <td>Tipe </td>
                <td>:</td>
                <td>{{ $booking->tipe_mobil }}</td>
            </tr>
        </table>
        <br>
        <table cellspacing='0' cellpadding='0'
            style='width:210px; font-size:12pt; font-family:calibri;  border-collapse: collapse;' border='0'>

            <tr>
                <td width='50%'>Service</td>
                <td width='10%'></td>
                <td width='10%'></td>
                <td width='10%'></td>
                <td width='13%' style='text-align:right;'>Price</td>
            <tr>
                <td colspan='5'>
                    <hr>
                </td>
            </tr>
            </tr>
            @foreach ($booking->bookingorder as $item)
            <tr>
                <td style='vertical-align:top'>{{ $item->product_name }}</td>
                <td style='vertical-align:top; text-align:right; padding-right:10px'></td>
                <td style='vertical-align:top; text-align:right; padding-right:10px'></td>
                <td style='vertical-align:top; text-align:right; padding-right:10px'></td>
                <td style='text-align:right; vertical-align:top'>{{ number_format($item->product_price, 0, ',', '.') }}</td>
            </tr>
            @if ($item->extraservice_price == 0)
                @else
                <tr>
                <td style='vertical-align:top'>{{ $item->extraservice_name }}</td>
                <td style='vertical-align:top; text-align:right; padding-right:10px'></td>
                <td style='vertical-align:top; text-align:right; padding-right:10px'></td>
                <td style='vertical-align:top; text-align:right; padding-right:10px'></td>
                <td style='text-align:right; vertical-align:top'>{{ number_format($item->extraservice_price, 0, ',', '.') }}</td>
            </tr>
                @endif
            @endforeach
            <tr>
                <td colspan='5'>
                    <hr>
                </td>
            </tr>


            @if ($transaksi->discount == 0)
            @else
           <tr>
            <td colspan = '4'><div style='text-align:right'>Diskon : </div></td><td style='text-align:right;'>{{ number_format($transaksi->discount, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr>

            <td colspan = '4'><div style='text-align:right'>Total : </div></td><td style='text-align:right;'>{{ number_format($transaksi->total, 0, ',', '.') }}</td>
            </tr>

        </table>
        <br>
        <br>
        <table style='width:210px; font-size:16pt; font-family:calibri; border-collapse: collapse;' border='0'>
            <tr>
                <td width='70%' align='CENTER' vertical-align:top'><span style='color:black;'>
                    <img src="data:image/png;base64, {!! $qrcode !!}">
            </td>
            </tr>
            <td width='70%' align='CENTER' vertical-align:top'><span style='color:black;'>
                    <span style='font-size:12pt'>***** TERIMA KASIH *****</span>

            </td>

        </table>

    </center>
</body>

</html>


