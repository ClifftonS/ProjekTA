<div class="col-10 my-3 offset-1">
    <div class="row">
        <p class="display-6 fw-bold">Stock Opname</p>
    </div>
    <div class="row justify-content-start mb-3">
        <div class="col-auto mt-1">Cari Opname</div>
        <div class="col-5 me-auto">
            <input type="text" class="input form-control" id="input" placeholder="Cari disini ....">
        </div>
        <div class="col-3 me-auto">
            <div class="row align-items-center">
                <input type="text" id="daterange" name="daterange" style="width: 240px" readonly />
            </div>
        </div>
        <div class="col-auto">
            <a class="btn btn-primary mb-3" role="button" data-bs-toggle="modal" data-bs-target="#Addstockop"
                data-bs-placement="top" style="display: flex">Tambah</a>
        </div>
    </div>
    <div class="search" id="search"></div>
</div>
@include('stockop.addstockop')
@include('stockop.editstockop')


<script>
    $(document).ready(function() {
        var today = moment();
        var page = 1;
        $("#daterange").daterangepicker({
            autoUpdateInput: false,
            startDate: today,
            endDate: today
        });

        $("#daterange").val(today.format('DD-MM-YYYY') + ' s/d ' + today.format('DD-MM-YYYY'));

        $("#daterange").trigger('apply.daterangepicker');

        // Fungsi untuk menangani perubahan tanggal
        $("#daterange").on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' s/d ' + picker.endDate.format(
                'DD-MM-YYYY'));
            // Setelah tanggal diubah, kita perlu memanggil fungsi-fungsi yang bergantung pada tanggal
            page = 1;
            search(page);
        });

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
        var dates = $("#daterange").val().split(' s/d ');
        var tgl1 = dates[0];
        var tgl2 = dates[1];
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxstockop') }}",
            data: {
                name: strcari,
                tgl1: tgl1,
                tgl2: tgl2,
                page: page
            },
            success: function(response) {
                $("#search").html(response);
            }
        });
    }
</script>
