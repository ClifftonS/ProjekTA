<div class="row">
    <table class="table table-hover table-bordered text-center table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th class="col-8" scope="col">Merk</th>
                <th class="col-1" scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datasend as $datatable)
                <tr>
                    <td>{{ $datatable->merk }}</td>
                    <td>
                        <a data-bs-toggle="modal" data-bs-target="#Editmerk"
                            data-id='{"idmerk":"{{ $datatable->id_merk }}","merk":"{{ $datatable->merk }}"}'
                            class="btn px-1 py-0 btn-primary edit text-decoration-none"><i
                                class="icon fa-solid fa-pen-to-square"></i></a>
                        |
                        <a data-bs-toggle="modal" data-bs-target="#Deletemerk"
                            data-id='{"idmerk":"{{ $datatable->id_merk }}"}'
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
