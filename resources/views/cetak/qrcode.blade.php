<html moznomarginboxes mozdisallowselectionprint>

<head>
    <title>QR CODE </title>
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
    <script>
        window.print();
        window.onafterprint = function() {
            setTimeout(function() {
                window.close();
            }, 1000);
        }

    </script>
</head>

<body style='font-family:tahoma; font-size:8pt;'>
    <center>

        <table style='width:250px; font-size:16pt; font-family:calibri; border-collapse: collapse;' border='0'>
            <tr>
                <td width='70%' align='CENTER' vertical-align:top'><span style='color:black;'>
                        {{ $qrcode }}
                </td>
            </tr>
            <td width='70%' align='CENTER' vertical-align:top'><span style='color:black;'>
                    <span style='font-size:12pt'>{{ $booking->no_pol_kendaraan }}</span>

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

    </center>
</body>

</html>

