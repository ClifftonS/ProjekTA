<table class="table table-borderless text-center align-middle" style="font-size: 12px">
    <thead style="border-bottom: 1px solid black">
        <tr>
            <th class="col-2" scope="col">Konsumen</th>
            <th class="col-2" scope="col">Total Transaksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datasend as $datatable)
            <tr>
                <td>{{ $datatable->nama }}</td>
                <td>{{ $datatable->total_trans }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
