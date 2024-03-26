<div class="col-10 my-3 offset-1">
    <div class="row justify-content-start mb-3">
        <div class="col-auto mt-1">Jenis Laporan</div>
        <div class="col-3">
            <select class="form-select" id="jenis" name="jenis" style="">
                <option value="pembelian">Pembelian</option>
                <option value="penjualan">Penjualan</option>
            </select>
        </div>
        <div class="col-4 ms-auto">
            <div class="row align-items-center">
                Periode Awal <input type="date" id="tanggal1" class="form-control me-2 ms-2" style="width: 45px">
                Periode Akhir<input type="date" id="tanggal2" class="form-control me-2 ms-2" style="width: 45px">
            </div>
        </div>
    </div>
    <div class="search d-flex justify-content-center" id="search"></div>
</div>


<script>
    $(document).ready(function() {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);
        $('#tanggal1').val("2024-01-01");
        $('#tanggal2').val(today);

        $("#tanggal1, #tanggal2").change(function() {
            search();
        });
        $("#jenis").change(function() {
            search();
        });
        search();
    });

    function search() {
        var jenis = $("#jenis").val();
        var tgl1 = $("#tanggal1").val();
        var tgl2 = $("#tanggal2").val();
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxlaporan') }}",
            data: {
                jenis: jenis,
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function(response) {
                $("#search").html(response);
            }
        });
    }
</script>
