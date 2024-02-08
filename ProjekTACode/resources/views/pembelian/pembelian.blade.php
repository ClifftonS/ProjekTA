<div class="col-10 my-3 offset-1">
    <div class="row justify-content-start mb-3">
        <div class="col-auto mt-1">Cari Transaksi</div>
        <div class="col-5 me-auto">
            <input type="text" class="input form-control" id="input" placeholder="Cari disini ....">
        </div>
        <div class="col-auto" id="addprodukid">
            <a class="btn btn-primary mb-3" role="button" data-bs-toggle="modal" data-bs-target="#Addpembelian"
                data-bs-placement="top" style="display: flex">Tambah</a>
        </div>
    </div>
    <div class="search d-flex justify-content-center" id="search"></div>
</div>

@include('pembelian.addpembelian')
@include('pembelian.editpembelian')
@include('pembelian.deletepembelian')


<script>
    $(document).ready(function() {
        search();

        $("#input").keyup(function() {
            search();
        });
    });

    function search() {
        var strcari = $("#input").val();
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxpembelian') }}",
            data: {
                name: strcari
            },
            success: function(response) {
                $("#search").html(response);
            }
        });
    }
</script>