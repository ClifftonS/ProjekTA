<div class="row">
    <table class="table table-hover table-bordered text-center table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th class="col-2" scope="col">Produk</th>
                <th class="col-2" scope="col">Jumlah</th>
                <th class="col-2" scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datasend as $datatable)
                <tr>
                    <td>{{ $datatable->nama_produk }}</td>
                    <td>{{ $datatable->total_qty }}</td>
                    <td>{{ number_format($datatable->total_harga, 0, ',', '.') }}</td>
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
