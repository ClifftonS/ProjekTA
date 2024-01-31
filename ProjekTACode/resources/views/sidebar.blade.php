<div class="col-2 vh-100 g-0">
    <div class="col-2 vh-100 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark position-fixed">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <svg class="bi me-2" width="16" height="16">
                <use xlink:href="#home" />
            </svg>
            <span class="fs-4">Berkat Mulia</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column Fmb-auto">
            <li class="nav-item mb-1">
                <a href="/konsumen" class="nav-link {{ Request::is('konsumen') ? 'active' : '' }}" aria-current="page">
                    <div class="ms-4 textnav">Konsumen</div>
                </a>
            </li>
            <li class="nav-item dropdown mb-1">
                <a href="/merk" class="nav-link {{ Request::is('merk') ? 'active' : '' }}" aria-current="page">
                    <div class="ms-4 textnav">Merk</div>
                </a>
            </li>
            <li class="mb-1">
                <a href="/kategori" class="nav-link {{ Request::is('kategori') ? 'active' : '' }}">
                    <div class="ms-4 textnav">Kategori</div>
                </a>
            </li>
            <li class="mb-1">
                <a href="/produk" class="nav-link {{ Request::is('anggota') ? 'active' : '' }}">
                    <div class="ms-4 textnav">Produk</div>
                </a>
            </li>
        </ul>
    </div>
</div>
