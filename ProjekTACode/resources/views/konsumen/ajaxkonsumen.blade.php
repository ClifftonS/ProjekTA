<div class="row">
    <table class="table table-hover table-bordered text-center table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th class="col-3" scope="col">Nama</th>
                <th class="col-2" scope="col">No Telp</th>
                <th class="col-3" scope="col">Alamat</th>
                <th class="col-1" scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datasend as $datatable)
                <tr>
                    <td>{{ $datatable->nama }}</td>
                    <td>{{ $datatable->telp }}</td>
                    <td>{{ $datatable->alamat }}</td>
                    <td>
                        <a data-bs-toggle="modal" data-bs-target="#Editkonsumen"
                            data-id='{"idkons":"{{ $datatable->id_konsumen }}","nama":"{{ $datatable->nama }}","telp":"{{ $datatable->telp }}","alamat":"{{ $datatable->alamat }}"}'
                            class="btn px-1 py-0 btn-primary edit text-decoration-none"><i
                                class="icon fa-solid fa-pen-to-square"></i></a>
                        |
                        <a data-bs-toggle="modal" data-bs-target="#Deletekonsumen"
                            data-id='{"idkons":"{{ $datatable->id_konsumen }}"}'
                            class="btn px-1 py-0 btn-primary delete text-decoration-none"><i
                                class="icon fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if ($totalPages > 1)
    <div class="row">
        <nav aria-label="...">
            <ul class="pagination d-flex justify-content-center">
                @if ($totalPages > 5)
                    <li class="page-item @if ($currentPage <= 3) disabled @endif">
                        <a class="page-link prev" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @endif
                @for ($page = $startPage; $page <= $endPage; $page++)
                    <li class="page-item @if ($currentPage == $page) active @endif" style="cursor: pointer;">
                        <a class="page-link nomer">{{ $page }}</a>
                    </li>
                @endfor
                @if ($totalPages > 5)
                    <li class="page-item @if ($currentPage >= $totalPages - 2) disabled @endif">
                        <a class="page-link next" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
