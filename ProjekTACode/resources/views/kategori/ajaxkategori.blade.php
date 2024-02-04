<table class="table table-hover table-bordered text-center table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th class="col-2" scope="col">Kategori</th>
            <th class="col-2" scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datasend as $datatable)
            <tr>
                <td>{{ $datatable->kategori }}</td>
                <td>
                    <a data-bs-toggle="modal" data-bs-target="#Editkategori"
                        data-id='{"idkategori":"{{ $datatable->id_kategori }}","kategori":"{{ $datatable->kategori }}"}'
                        class="edit text-decoration-none"><i class="icon fa-solid fa-pen-to-square"></i></a>
                    |
                    <a data-bs-toggle="modal" data-bs-target="#Deletekategori"
                        data-id='{"idkategori":"{{ $datatable->id_kategori }}"}' class="delete text-decoration-none"><i
                            class="icon fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
