<div class="modal fade" id="Addproduk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Tambah Produk
                </h5>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="nama" class="col-form-label">Produk</label>
                    </div>
                    <div class="col-7">
                        <input type="text" name="nama" id="namaadd" maxlength = "50" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Nama"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-namaadd"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="merkadd" class="col-form-label">Merk</label>
                    </div>
                    <div class="col-7">
                        <select class="form-select" id="merkadd" name="merk" style=""required>
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-merkadd"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="kategoriadd" class="col-form-label">Kategori</label>
                    </div>
                    <div class="col-7">
                        <select class="form-select" id="kategoriadd" name="kategori" style=""required>
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-kategoriadd"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="stokadd" class="col-form-label">Stok</label>
                    </div>
                    <div class="col-7">
                        <input type="number" name="stok" id="stokadd" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan stok"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-stokadd"></div>
                </div>

                <div class="mt-3" style="margin-bottom: 20%"></div>
                <div class="d-flex justify-content-center mb-4">

                    <input type="submit" id="addproduk" class="btn shadow rounded"
                        style="background-color: #364F6B; color: white; width: 125px" value="Tambah">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#Addproduk').on('show.bs.modal', function(e) {
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxprodukadd') }}",
            success: function(response) {
                var merkSelect = $(
                    '<select class="form-select select2" id="merkadd" name="merk" style="background-color: #F4F9FF; border-radius: 10px;" required>'
                );

                var kategoriSelect = $(
                    '<select class="form-select select2" id="kategoriadd" name="kategori" style="background-color: #F4F9FF; border-radius: 10px;" required>'
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

                $('#merkadd').replaceWith(merkSelect);
                $('#kategoriadd').replaceWith(kategoriSelect);

                $('.select2').select2({
                    dropdownParent: $("#Addproduk")
                });


            }
        });
    });
    $('#addproduk').click(function(e) {
        e.preventDefault();

        let nama = $('#namaadd').val();
        let merk = $('#merkadd').val();
        let kategori = $('#kategoriadd').val();
        let stok = $('#stokadd').val();
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: "/addproduk",
            data: {
                "nama": nama,
                "merk": merk,
                "kategori": kategori,
                "stok": stok,
                "_token": token
            },
            success: function(response) {
                search(1);
                $('#Addproduk').modal('hide');
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
                    $('#alert-namaadd').removeClass('d-none');
                    $('#alert-namaadd').addClass('d-block');
                    //add message to alert
                    $('#alert-namaadd').html(error.responseJSON.nama[0]);
                } else {
                    $('#alert-namaadd').removeClass('d-block');
                    $('#alert-namaadd').addClass('d-none');
                }

                if (error.responseJSON.merk && error.responseJSON.merk[0]) {
                    //show alert
                    $('#alert-merkadd').removeClass('d-none');
                    $('#alert-merkadd').addClass('d-block');
                    //add message to alert
                    $('#alert-merkadd').html(error.responseJSON.merk[0]);
                } else {
                    $('#alert-merkadd').removeClass('d-block');
                    $('#alert-merkadd').addClass('d-none');
                }

                if (error.responseJSON.kategori && error.responseJSON.kategori[0]) {
                    //show alert
                    $('#alert-kategoriadd').removeClass('d-none');
                    $('#alert-kategoriadd').addClass('d-block');
                    //add message to alert
                    $('#alert-kategoriadd').html(error.responseJSON.kategori[0]);
                } else {
                    $('#alert-kategoriadd').removeClass('d-block');
                    $('#alert-kategoriadd').addClass('d-none');
                }

                if (error.responseJSON.stok && error.responseJSON.stok[0]) {
                    //show alert
                    $('#alert-stokadd').removeClass('d-none');
                    $('#alert-stokadd').addClass('d-block');
                    //add message to alert
                    $('#alert-stokadd').html(error.responseJSON.stok[0]);
                } else {
                    $('#alert-stokadd').removeClass('d-block');
                    $('#alert-stokadd').addClass('d-none');
                }

            }
        });
    });
    $('#Addproduk').on('hidden.bs.modal', function() {
        $('#namaadd').val("");
        $('#merkadd').val("");
        $('#kategoriadd').val("");
        $('#stokadd').val("");
        $('#alert-namaadd').removeClass('d-block');
        $('#alert-namaadd').addClass('d-none');
        $('#alert-merkadd').removeClass('d-block');
        $('#alert-merkadd').addClass('d-none');
        $('#alert-kategoriadd').removeClass('d-block');
        $('#alert-kategoriadd').addClass('d-none');
        $('#alert-stokadd').removeClass('d-block');
        $('#alert-stokadd').addClass('d-none');
    });
</script>
