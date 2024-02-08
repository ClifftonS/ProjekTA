<table class="table table-hover table-bordered text-center table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th class="col-2" scope="col">Nama Produk</th>
            <th class="col-2" scope="col">Tanggal</th>
            <th class="col-2" scope="col">Qty</th>
            <th class="col-2" scope="col">Harga</th>
            <th class="col-2" scope="col">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datasend as $datatable)
            <tr>
                <td>{{ $datatable->nama_produk }}</td>
                <td>{{ $datatable->tanggal_pembelian }}</td>
                <td>{{ $datatable->qty_pembelian }}</td>
                <td>{{ $datatable->harga_pembelian }}</td>
                <td>{{ $datatable->subtotal_pembelian }}</td>
                <td>
                    <a data-bs-toggle="modal" data-bs-target="#Editpembelian"
                        data-id='{"idproduk":"{{ $datatable->id_produk }}","produk":"{{ $datatable->nama_produk }}","merk":"{{ $datatable->id_merk }}","kategori":"{{ $datatable->id_kategori }}","stok":"{{ $datatable->stok_produk }}"}'
                        class="edit text-decoration-none"><i class="icon fa-solid fa-pen-to-square"></i></a>
                    |
                    <a data-bs-toggle="modal" data-bs-target="#Deletepembelian"
                        data-id='{"idproduk":"{{ $datatable->id_produk }}"}' class="delete text-decoration-none"><i
                            class="icon fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
