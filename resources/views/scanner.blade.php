<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<Style>
    Body {
        background-color: #0a0a0a;
    }

    .camera {
        background-color: #121212;
        color: white;
        border-radius: 10px;
    }

    .container {
        width: 300px;
        /* display: flex;
        justify-content: center;
        align-items: center; */
    }
</Style>

<body>
    <div class="container">
        <div class="camera" id="render-app"></div>
    </div>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QRCodeScanner = new Html5QrcodeScanner(
            "render-app", {
                fps: 10,
                qrbox: {
                    width: 200,
                    height: 200,
                },
                formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
            });

        function onScanSuccess(decodedText, decodedResult) {
            window.location.href = decodedResult.decodedText;
            html5QRCodeScanner.clear();
        }

        html5QRCodeScanner.render(onScanSuccess);
    </script>
</body>

</html>
