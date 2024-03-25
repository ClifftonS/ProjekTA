<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        h4 {
            margin: 0;
            font-weight: bold;
        }

        h3 {
            font-size: 15px;
            margin: 0;
        }

        h1 {
            font-size: 50px;
            margin: 0;
        }

        .w-full {
            width: 100%;
        }

        .w-half {
            width: 50%;
            text-align: center;
        }

        .margin-top {
            margin-top: 1.25rem;
        }

        .footer {
            position: absolute;
            font-size: 0.875rem;
            bottom: 0;
            width: 97%;
            padding: 1rem;
            background-color: rgb(241 245 249);
            text-align: center;
        }

        table {
            width: 100%;
            border-spacing: 0;
        }

        table.products {
            font-size: 0.875rem;
        }

        table.products tr {
            background-color: rgb(96 165 250);
        }

        table.products th {
            color: #ffffff;
            padding: 0.5rem;
        }

        table tr.items {
            background-color: rgb(241 245 249);
        }

        table tr.items td {
            padding: 0.5rem;
            text-align: center;
        }

        .total {
            text-align: right;
            margin-top: 1rem;
            font-size: 0.875rem;
            font-weight: bold;
        }
    </style>

    {{-- <link rel="stylesheet" href="{{ URL::asset('pdf.css') }}"> --}}
</head>

<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <h1>Berkat Mulia</h1>
                <h3>Jl. Sunan Ngerang 58 Juwana</h3>
                <h3>081357406948</h3>
            </td>
        </tr>
    </table>

    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div>
                        <h4>Pembeli:</h4>
                    </div>
                    <div>{{ $data[0]->nama }}</div>
                    <div>{{ $data[0]->telp }}</div>
                    <div>{{ $data[0]->alamat }}</div>
                </td>
                <td class="w-half">
                    <div>
                        <h4>Transaksi:</h4>
                    </div>
                    <div>{{ $data[0]->id_penjualan }}</div>
                    <div>{{ date('d-m-Y', strtotime($data[0]->tanggal_penjualan)) }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
            @foreach ($data as $item)
                <tr class="items">
                    <td>
                        {{ $item->nama_produk }}
                    </td>
                    <td>
                        {{ $item->qty_detail }}
                    </td>
                    <td>
                        {{ $item->harga_detail }}
                    </td>
                    <td>
                        {{ $item->harga_detail * $item->qty_detail }}
                    </td>

                </tr>
            @endforeach
        </table>
    </div>

    <div class="total">
        Total: {{ $data[0]->total_penjualan }}
    </div>

    <div class="footer margin-top">
        <div>Terimakasih atas pembeliannya</div>
        <div>&copy; Berkat Mulia</div>
    </div>
</body>



</html>
