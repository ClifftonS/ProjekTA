<table class="table table-borderless text-center align-middle" style="font-size: 12px">
    <thead style="border-bottom: 1px solid black">
        <tr>
            <th class="col-2" scope="col">Produk</th>
            <th class="col-2" scope="col">Total Terjual</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datasend as $datatable)
            <tr>
                <td>{{ $datatable->nama_produk }}</td>
                <td>{{ $datatable->total_qty }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
