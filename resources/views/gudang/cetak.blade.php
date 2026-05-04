<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Barcode</title>
    <style>
        body { padding: 0; margin: 0; }
        .barcode-item {
            display: inline-block;
            margin: 15px;
            text-align: center;
            width: 150px;
        }
        .qr-image {
            width: 150px;
            height: 150px;
        }
        .barcode-svg svg {
            width: 150px;
            height: 150px;
        }
    </style>
</head>

<body>
    @foreach ($qrcode as $item)
        <div class="barcode-item">
            <div class="barcode-svg">{!! $item['barcode'] !!}</div>
            <div style="font-family: sans-serif; font-size: 12px; margin-top: 10px; font-weight: bold;">
                {{ $item['nomor'] }}
            </div>
        </div>
    @endforeach
</body>

</html>
