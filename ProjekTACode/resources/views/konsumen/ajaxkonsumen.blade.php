<table class="table table-hover table-bordered text-center table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th class="col-2" scope="col">Nama</th>
            <th class="col-2" scope="col">No Telp</th>
            <th class="col-2" scope="col">Alamat</th>
            <th class="col-2" scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datasend as $datatable)
            <tr>
                <td>{{ $datatable->nama }}</td>
                <td>{{ $datatable->telp }}</td>
                <td>{{ $datatable->alamat }}</td>
                {{-- <td><a data-bs-toggle="modal" data-bs-target="#Editanggota"
                        data-id='{"idagt":"{{ $datatable->id_agt }}","nama":"{{ $datatable->nama }}","notelp":"{{ $datatable->no_telp }}"}'
                        class="edit text-decoration-none"><i class="icon fa-solid fa-pen-to-square"></i></a>
                    |
                    <a data-bs-toggle="modal" data-bs-target="#Deleteanggota"
                        data-id='{"idagt":"{{ $datatable->id_agt }}"}' class="delete text-decoration-none"><i
                            class="icon fa-solid fa-trash-can"></i></a>
                </td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
