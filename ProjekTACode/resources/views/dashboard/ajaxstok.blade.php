<table class="table table-borderless text-center align-middle" style="font-size: 14px">
    <thead style="border-bottom: 1px solid black">
        <tr>
            <th class="col-2" scope="col">Produk</th>
            <th class="col-2" scope="col">Qty < 10</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datasend as $datatable)
            <tr>
                <td>{{ $datatable->nama_produk }}
                    @foreach ($terlaris as $terlaris_produk)
                        @if ($terlaris_produk->id_produk == $datatable->id_produk)
                            <span><i class="fa-regular fa-star"></i></span>
                        @endif
                    @endforeach
                </td>
                <td>{{ $datatable->stok_produk }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
