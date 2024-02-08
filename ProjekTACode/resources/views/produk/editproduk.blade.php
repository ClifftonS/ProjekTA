<div class="modal fade" id="Editproduk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Edit Produk
                </h5>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="nama" class="col-form-label">Produk</label>
                    </div>
                    <div class="col-7">
                        <input type="text" name="nama" id="namaedit" maxlength = "100" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Nama"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-namaedit"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="merkadd" class="col-form-label">Merk</label>
                    </div>
                    <div class="col-7">
                        <select class="form-select" id="merkedit" name="merk" style=""required>
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-merkedit"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="kategoriadd" class="col-form-label">Kategori</label>
                    </div>
                    <div class="col-7">
                        <select class="form-select" id="kategoriedit" name="kategori" style=""required>
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-kategoriedit"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="stokadd" class="col-form-label">Stok</label>
                    </div>
                    <div class="col-7">
                        <input type="number" name="stok" id="stokedit" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan stok"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-stokedit"></div>
                </div>

                <div class="mt-3" style="margin-bottom: 20%"></div>
                <div class="d-flex justify-content-center mb-4">

                    <input type="submit" id="editproduk" class="btn shadow rounded"
                        style="background-color: #364F6B; color: white; width: 125px" value="Edit">
                </div>
            </div>
            <input type="hidden" name="idedit" id="idedit">
        </div>
    </div>
</div>

<script>
    $('#Editproduk').on('show.bs.modal', function(e) {
        var idproduk = $(e.relatedTarget).data('id').idproduk;
        var nama = $(e.relatedTarget).data('id').produk;
        var merk = $(e.relatedTarget).data('id').merk;
        var kategori = $(e.relatedTarget).data('id').kategori;
        var stok = $(e.relatedTarget).data('id').stok;
        $(e.currentTarget).find('input[id="idedit"]').val(idproduk);
        $(e.currentTarget).find('input[id="namaedit"]').val(nama);
        $(e.currentTarget).find('input[id="stokedit"]').val(stok);

        $.ajax({
            type: "get",
            url: "{{ url('/ajaxprodukadd') }}",
            success: function(response) {
                var merkSelect = $(
                    '<select class="form-select" id="merkedit" name="merk" style="" required>');

                var kategoriSelect = $(
                    '<select class="form-select" id="kategoriedit" name="kategori" style="" required>'
                );

                if (response.merk.length == 0) {
                    merkSelect.append('<option value="kosong">Tidak ada merk</option>');
                } else {
                    $.each(response.merk, function(index, merkoption) {
                        merkSelect.append(
                            `<option value="${merkoption.id_merk}">${merkoption.merk}</option>`
                        );
                    });
                }

                if (response.kategori.length == 0) {
                    kategoriSelect.append('<option value="kosong">Tidak ada kategori</option>');
                } else {
                    $.each(response.kategori, function(index, kategorioption) {
                        kategoriSelect.append(
                            `<option value="${kategorioption.id_kategori}">${kategorioption.kategori}</option>`
                        );
                    });
                }

                $('#merkedit').replaceWith(merkSelect);
                $('#kategoriedit').replaceWith(kategoriSelect);
                $("#kategoriedit option[value='" + kategori + "']").attr('selected', true);
                $("#merkedit option[value='" + merk + "']").attr('selected', true);
            }
        });
    });
    $('#editproduk').click(function(e) {
        e.preventDefault();

        let id = $('#idedit').val();
        let nama = $('#namaedit').val();
        let merk = $('#merkedit').val();
        let kategori = $('#kategoriedit').val();
        let stok = $('#stokedit').val();
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: "/editproduk",
            data: {
                "id": id,
                "nama": nama,
                "merk": merk,
                "kategori": kategori,
                "stok": stok,
                "_token": token
            },
            success: function(response) {
                search();
                $('#Editproduk').modal('hide');
                Swal.fire({
                    title: "Success",
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 2000
                });
            },
            error: function(error) {

                if (error.responseJSON.nama && error.responseJSON.nama[0]) {
                    //show alert
                    $('#alert-namaedit').removeClass('d-none');
                    $('#alert-namaedit').addClass('d-block');
                    //add message to alert
                    $('#alert-namaedit').html(error.responseJSON.nama[0]);
                } else {
                    $('#alert-namaedit').removeClass('d-block');
                    $('#alert-namaedit').addClass('d-none');
                }

                if (error.responseJSON.merk && error.responseJSON.merk[0]) {
                    //show alert
                    $('#alert-merkedit').removeClass('d-none');
                    $('#alert-merkedit').addClass('d-block');
                    //add message to alert
                    $('#alert-merkedit').html(error.responseJSON.merk[0]);
                } else {
                    $('#alert-merkedit').removeClass('d-block');
                    $('#alert-merkedit').addClass('d-none');
                }

                if (error.responseJSON.kategori && error.responseJSON.kategori[0]) {
                    //show alert
                    $('#alert-kategoriedit').removeClass('d-none');
                    $('#alert-kategoriedit').addClass('d-block');
                    //add message to alert
                    $('#alert-kategoriedit').html(error.responseJSON.kategori[0]);
                } else {
                    $('#alert-kategoriedit').removeClass('d-block');
                    $('#alert-kategoriedit').addClass('d-none');
                }

                if (error.responseJSON.stok && error.responseJSON.stok[0]) {
                    //show alert
                    $('#alert-stokedit').removeClass('d-none');
                    $('#alert-stokedit').addClass('d-block');
                    //add message to alert
                    $('#alert-stokedit').html(error.responseJSON.stok[0]);
                } else {
                    $('#alert-stokedit').removeClass('d-block');
                    $('#alert-stokedit').addClass('d-none');
                }

            }
        });
    });
    $('#Editproduk').on('hidden.bs.modal', function() {
        $('#namaedit').val("");
        $('#alert-namaedit').removeClass('d-block');
        $('#alert-namaedit').addClass('d-none');
        $('#alert-merkedit').removeClass('d-block');
        $('#alert-merkedit').addClass('d-none');
        $('#alert-kategoriedit').removeClass('d-block');
        $('#alert-kategoriedit').addClass('d-none');
        $('#alert-stokedit').removeClass('d-block');
        $('#alert-stokedit').addClass('d-none');
    });
</script>
