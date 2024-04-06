<table class="table table-hover table-bordered text-center table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th class="col-2" scope="col">Nama Produk</th>
            <th class="col-2" scope="col">Merk</th>
            <th class="col-2" scope="col">Kategori</th>
            <th class="col-2" scope="col">Stok</th>
            <th class="col-1" scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datasend as $datatable)
            <tr>
                <td>{{ $datatable->nama_produk }}</td>
                <td>{{ $datatable->merk }}</td>
                <td>{{ $datatable->kategori }}</td>
                <td>{{ $datatable->stok_produk }}</td>
                <td>
                    <a data-bs-toggle="modal" data-bs-target="#Editproduk"
                        data-id='{"idproduk":"{{ $datatable->id_produk }}","produk":"{{ $datatable->nama_produk }}","merk":"{{ $datatable->id_merk }}","kategori":"{{ $datatable->id_kategori }}","stok":"{{ $datatable->stok_produk }}"}'
                        class="btn px-1 py-0 btn-primary edit text-decoration-none"><i
                            class="icon fa-solid fa-pen-to-square"></i></a>
                    |
                    <a data-bs-toggle="modal" data-bs-target="#Deleteproduk"
                        data-id='{"idproduk":"{{ $datatable->id_produk }}"}'
                        class="btn px-1 py-0 btn-primary delete text-decoration-none"><i
                            class="icon fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
