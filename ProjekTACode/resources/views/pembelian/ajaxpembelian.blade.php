<table class="table table-hover table-bordered text-center table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th class="col-2" scope="col">Id Pembelian</th>
            <th class="col-2" scope="col">Supplier</th>
            <th class="col-2" scope="col">Tanggal</th>
            <th class="col-2" scope="col">Total</th>
            <th class="col-1" scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datasend as $datatable)
            <tr>
                <td>{{ $datatable->id_pembelian }}</td>
                <td>{{ $datatable->nama }}</td>
                <td>{{ date('d-m-Y', strtotime($datatable->tanggal_pembelian)) }}</td>
                <td>{{ number_format($datatable->total_pembelian, 0, ',', '.') }}</td>
                <td>
                    <a data-bs-toggle="modal" data-bs-target="#Editpembelian"
                        data-id='{"idpembelian":"{{ $datatable->id_pembelian }}"}'
                        class="btn px-1 py-0 btn-primary edit text-decoration-none"><i
                            class="icon fa-solid fa-pen-to-square"></i></a>
                    |
                    <a data-bs-toggle="modal" data-bs-target="#Lihatpembelian"
                        data-id='{"idpembelian":"{{ $datatable->id_pembelian }}"}'
                        class="btn px-1 py-0 btn-primary delete text-decoration-none"><i
                            class="icon fa-solid fa-file"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
