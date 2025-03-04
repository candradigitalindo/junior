<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barcode</title>
</head>

<body>
    @foreach ($qrcode as $item)
        <img style="margin: 15px" src="data:image/png;base64, {!! $item['barcode'] !!}">
    @endforeach
</body>

</html>
