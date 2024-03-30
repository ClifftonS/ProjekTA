<div class="col-10 my-3 offset-1">
    <div class="row">
        <p class="display-6 fw-bold">Pembelian</p>
    </div>
    <div class="row justify-content-start mb-3">
        <div class="col-auto mt-1">Cari Transaksi</div>
        <div class="col-5 me-auto">
            <input type="text" class="input form-control" id="input" placeholder="Cari disini ....">
        </div>
        <div class="col-3 me-auto">
            <div class="row align-items-center">
                From <input type="date" id="tanggal1" class="form-control me-2 ms-2" style="width: 45px">
                To<input type="date" id="tanggal2" class="form-control me-2 ms-2" style="width: 45px">
            </div>
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
@include('pembelian.lihatpembelian')


<script>
    $(document).ready(function() {


        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);
        $('#tanggal1').val(today);
        $('#tanggal2').val(today);

        $("#input").keyup(function() {
            search();
        });

        $("#tanggal1, #tanggal2").change(function() {
            search();
        });

        search();
    });

    function search() {
        var strcari = $("#input").val();
        var tgl1 = $("#tanggal1").val();
        var tgl2 = $("#tanggal2").val();
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxpembelian') }}",
            data: {
                name: strcari,
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function(response) {
                $("#search").html(response);
            }
        });
    }
</script>
