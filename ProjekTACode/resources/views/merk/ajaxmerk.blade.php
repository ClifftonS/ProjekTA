<table class="table table-hover table-bordered text-center table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th class="col-2" scope="col">Merk</th>
            <th class="col-2" scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datasend as $datatable)
            <tr>
                <td>{{ $datatable->merk }}</td>
                <td>
                    <a data-bs-toggle="modal" data-bs-target="#Editmerk"
                        data-id='{"idmerk":"{{ $datatable->id_merk }}","merk":"{{ $datatable->merk }}"}'
                        class="edit text-decoration-none"><i class="icon fa-solid fa-pen-to-square"></i></a>
                    |
                    <a data-bs-toggle="modal" data-bs-target="#Deletemerk"
                        data-id='{"idmerk":"{{ $datatable->id_merk }}"}' class="delete text-decoration-none"><i
                            class="icon fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
