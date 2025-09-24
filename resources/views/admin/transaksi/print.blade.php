<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Laundry</title>
    <style>
        .body {
            font-family: monospace;
            width: 80mm;
            margin: auto;
            padding: 5px;
        }

        .struk {
            text-align: center;
        }

        .line {
            margin: 5px 0;
            border-top: 1px dashed black;
        }

        .info, .products, .summary {
            text-align: left;
        }

        .products .item {
            margin-bottom: 5px;
        }

        .products .item-qty {
            display: flex;
            justify-content: space-between;
        }

        .info .row, .summary .row {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;

        }

        footer {
            text-align: center;
            font-size: 13px;
            margin-top: 10px;
        }

        @media print {
            body {
                width: 80mm;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="struk">
        <div class="struk-header">
            <h3>Laundry Diri</h3>
            <h2>Cepat dan Bersih</h2>

            <div class="info text-center">
                Jl. Karet Baru Benhil Jakarta Pusat
                <br>
                082297789349
            </div>
        </div>
        <div class="line"></div>
        <div class="info">
            <div class="row">
                <span>{{ $order->created_at->format('d M Y') }}</span>
                <span>{{ $order->created_at->format('H:i') }}</span>
            </div>
            <div class="row">
                <span>Chasier</span>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <div class="row">
                <span>Order Id</span>
                <span>{{ $order->order_code }}</span>
            </div>
        </div>
        <div class="line"></div>
        <div class="products">
            @foreach ($order->details as $detail)
            <div class="item">
                <strong>{{ $detail->service->service_name }}</strong>
                <div class="item-qty">
                    <span>{{ $detail->qty }} kg x Rp {{ number_format($detail->service->price) }}</span>
                    <span>{{ $detail->subtotal }}</span>
                </div>
            </div>
            @endforeach
        </div>
        <div class="line"></div>
        <div class="summary">
            <div class="row">
                <span>Total</span>
                <span>Rp {{ number_format($order->total) }}</span>
            </div>
        </div>
        <div class="line"></div>
        <footer class="text-center">
            Terimakasih sudah menggunakan layanan kami
        </footer>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
