<table class="table table-hover table-bordered text-center table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th class="col-2" scope="col">Produk</th>
            <th class="col-2" scope="col">Jumlah</th>
            <th class="col-2" scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datasend as $datatable)
            <tr>
                <td>{{ $datatable->nama_produk }}</td>
                <td>{{ $datatable->total_qty }}</td>
                <td>{{ number_format($datatable->total_harga, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
