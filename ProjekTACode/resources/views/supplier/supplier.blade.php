<div class="col-10 my-3 offset-1">
    <div class="row">
        <p class="display-6 fw-bold">Supplier</p>
    </div>
    <div class="row justify-content-start mb-3">
        <div class="col-auto mt-1">Cari Supplier</div>
        <div class="col-5 me-auto">
            <input type="text" class="input form-control" id="input" placeholder="Cari disini ....">
        </div>
        <div class="col-auto">
            <a class="btn btn-primary mb-3" role="button" data-bs-toggle="modal" data-bs-target="#Addsupplier"
                data-bs-placement="top" style="display: flex">Tambah</a>
        </div>
    </div>
    <div class="search" id="search"></div>
</div>

@include('supplier.addsupplier')
@include('supplier.editsupplier')
@include('supplier.deletesupplier')


<script>
    $(document).ready(function() {
        $('#telpadd').inputmask('numeric', {
            autoGroup: true,
            digits: 0,
            allowMinus: false,
            rightAlign: false,
            placeholder: "",
            showMaskOnHover: false
        });
        $('#telpedit').inputmask('numeric', {
            autoGroup: true,
            digits: 0,
            allowMinus: false,
            rightAlign: false,
            placeholder: ""
        });
        var page = 1;
        search(page);
        $("#input").keyup(function() {
            search(page);
        });
        $(document).on('click', '.page-link', function() {
            var page = $(this).text(); // Dapatkan nomor halaman dari teks tombol
            search(page);
        });
    });

    function search(page) {
        var strcari = $("#input").val();
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxsupplier') }}",
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
