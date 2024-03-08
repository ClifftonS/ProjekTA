<div class="col-2 vh-100 g-0">
    <div class="col-2 vh-100 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark position-fixed">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <svg class="bi me-2" width="16" height="16">
                <use xlink:href="#home" />
            </svg>
            <span class="fs-4">Berkat Mulia</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column Fmb-auto" id="menu">
            <li class="mb-1">
                <a id="dashboard" class="nav-link text-white">
                    <i class="fa-solid fa-house ms-2"></i>
                    <span class="ms-2">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mb-1 disabled">
                <a href="#sidemaster" class="nav-link text-white" data-bs-toggle="collapse">
                    <i class="fa-solid fa-database ms-2"></i>
                    <span class="ms-2">Master Data</span>
                    <i class="fa-solid fa-caret-right ms-3"></i>

                </a>
                <ul class="collapse flex-column" id="sidemaster" style="list-style-type: none;">
                    <li class="nav-item mb-1">
                        <a id="konsumen" class="nav-link" aria-current="page">
                            <div class=" ms-4 textnav">Konsumen</div>
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a id="merk" class="nav-link" aria-current="page">
                            <div class="ms-4 textnav">Merk</div>
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a id="kategori" class="nav-link">
                            <div class="ms-4 textnav">Kategori</div>
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a id="produk" class="nav-link">
                            <div class="ms-4 textnav">Produk</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item mb-1 disabled">
                <a href="#sidetransaksi" class="nav-link text-white" data-bs-toggle="collapse">
                    <i class="fa-solid fa-wallet ms-2"></i>
                    <span class="ms-2">Transaksi</span>
                    <i class="fa-solid fa-caret-right" style="margin-left: 34px;"></i>

                </a>
                <ul class="collapse flex-column" id="sidetransaksi" style="list-style-type: none;">
                    <li class="nav-item mb-1">
                        <a id="penjualan" class="nav-link" aria-current="page">
                            <div class=" ms-4 textnav">Penjualan</div>
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a id="pembelian" class="nav-link" aria-current="page">
                            <div class="ms-4 textnav">Pembelian</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="mb-1">
                <a id="laporan" class="nav-link text-white">
                    <i class="fa-solid fa-file ms-2"></i>
                    <span class="ms-2">Laporan</span>
                </a>
            </li>
        </ul>

    </div>
    <div class="col-2 position-absolute py-4 bottom-0 text-white">
        <hr>
        <a href="/logout" class="text-white text-decoration-none d-flex justify-content-center">Keluar</a>
    </div>
</div>
