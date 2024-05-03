<div class="col-10 my-3 offset-1">
    <div class="row">
        <p class="display-6 fw-bold">Produk</p>
    </div>
    <div class="row justify-content-start mb-3">
        <div class="col-auto mt-1">Cari Produk</div>
        <div class="col-5 me-auto">
            <input type="text" class="input form-control" id="input" placeholder="Cari disini ....">
        </div>
        <div class="col-auto" id="addprodukid">
            <a class="btn btn-primary mb-3" role="button" data-bs-toggle="modal" data-bs-target="#Addproduk"
                data-bs-placement="top" style="display: flex">Tambah</a>
        </div>
    </div>
    <div class="search" id="search"></div>
</div>

@include('produk.addproduk')
@include('produk.editproduk')
@include('produk.deleteproduk')


<script>
    $(document).ready(function() {
        var page = 1;
        search(page);
        $("#input").keyup(function() {
            page = 1;
            search(page);
        });
        $(document).on('click', '.nomer', function() {
            page = $(this).text(); // Dapatkan nomor halaman dari teks tombol
            search(page);
        });
        $(document).on('click', '.prev', function() {
            page--;
            search(page);
        });
        $(document).on('click', '.next', function() {
            page++;
            search(page);
        });
    });

    function search(page) {
        var strcari = $("#input").val();
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxproduk') }}",
            data: {
                name: strcari,
                page: page
            },
            success: function(response) {
                $("#search").html(response);
            }
        });
    }
</script>
