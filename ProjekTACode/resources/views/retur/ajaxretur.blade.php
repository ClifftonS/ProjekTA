<table class="table table-hover table-bordered text-center table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th class="col-2" scope="col">Id Penjualan</th>
            <th class="col-2" scope="col">Konsumen</th>
            <th class="col-2" scope="col">Tanggal</th>
            <th class="col-2" scope="col">Total</th>
            <th class="col-1" scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datasend as $datatable)
            <tr>
                <td>{{ $datatable->id_penjualan }}</td>
                <td>{{ $datatable->nama }}</td>
                <td>{{ date('d-m-Y', strtotime($datatable->tanggal_penjualan)) }}</td>
                <td>{{ number_format($datatable->total_penjualan, 0, ',', '.') }}</td>
                <td>
                    <a data-bs-toggle="modal" data-bs-target="#Editretur"
                        data-id='{"idpembelian":"{{ $datatable->id_penjualan }}"}'
                        class="btn px-1 py-0 btn-primary edit text-decoration-none"><i
                            class="icon fa-solid fa-right-left"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
