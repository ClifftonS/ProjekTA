<div class="row">
    <table class="table table-hover table-bordered text-center table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th class="col-2" scope="col">ID</th>
                <th class="col-2" scope="col">Produk</th>
                <th class="col-2" scope="col">Jumlah Sistem</th>
                <th class="col-2" scope="col">Jumlah Hitung</th>
                <th class="col-2" scope="col">Keterangan</th>
                <th class="col-2" scope="col">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datasend as $datatable)
                <tr>
                    <td>{{ $datatable->id_stockop }}</td>
                    <td>{{ $datatable->nama_produk }}</td>
                    <td>{{ $datatable->jumlah_sistem }}</td>
                    <td>{{ $datatable->jumlah_hitung }}</td>
                    <td>{{ $datatable->keterangan }}</td>
                    <td>{{ date('d-m-Y', strtotime($datatable->tgl_stockop)) }}</td>
                    {{-- <td>
                    <a data-bs-toggle="modal" data-bs-target="#Editstockop"
                        data-id='{"idkategori":"{{ $datatable->id_kategori }}","kategori":"{{ $datatable->kategori }}"}'
                        class="edit text-decoration-none"><i class="icon fa-solid fa-pen-to-square"></i></a>
                </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if ($totalPages > 1)
    <div class="row">
        <nav aria-label="...">
            <ul class="pagination d-flex justify-content-center">
                @for ($page = 1; $page <= $totalPages; $page++)
                    <li class="page-item @if ($currentPage == $page) active @endif" style="cursor: pointer;">
                        <a class="page-link">{{ $page }}</a>
                    </li>
                @endfor
            </ul>
        </nav>
    </div>
@endif
