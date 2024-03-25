<div class="col-10 my-3 offset-1">
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
    <div class="search d-flex justify-content-center" id="search"></div>
</div>

@include('supplier.addsupplier')
@include('supplier.editsupplier')
@include('supplier.deletesupplier')


<script>
    $(document).ready(function() {
        search();
        $("#input").keyup(function() {
            search();
        });
    });

    function formatAngka(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '');
        return number_string;
    }

    function search() {
        var strcari = $("#input").val();
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxsupplier') }}",
            data: {
                name: strcari
            },
            success: function(response) {
                $("#search").html(response);
            }
        });
    }
</script>
