<table class="table table-hover table-bordered text-center table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th class="col-4" scope="col">Nama</th>
            <th class="col-4" scope="col">No Telp</th>
            <th class="col-1" scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datasend as $datatable)
            <tr>
                <td>{{ $datatable->nama }}</td>
                <td>{{ $datatable->telp }}</td>
                <td>
                    <a data-bs-toggle="modal" data-bs-target="#Editsupplier"
                        data-id='{"idsupl":"{{ $datatable->id_supplier }}","nama":"{{ $datatable->nama }}","telp":"{{ $datatable->telp }}"}'
                        class="btn px-1 py-0 btn-primary edit text-decoration-none"><i
                            class="icon fa-solid fa-pen-to-square"></i></a>
                    |
                    <a data-bs-toggle="modal" data-bs-target="#Deletesupplier"
                        data-id='{"idsupl":"{{ $datatable->id_supplier }}"}'
                        class="btn px-1 py-0 btn-primary delete text-decoration-none"><i
                            class="icon fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
