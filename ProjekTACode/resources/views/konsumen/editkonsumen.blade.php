<div class="modal fade" id="Editkonsumen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Edit Konsumen
                </h5>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="nama" class="col-form-label">Nama</label>
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
                <div class="mt-0"></div>
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="telp" class="col-form-label">No Telp</label>
                    </div>
                    <div class="col-7">
                        <input type="text" name="telp" id="telpedit" maxlength = "15" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan NoTelp"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-telpedit"></div>
                </div>
                <div class="mt-0"></div>
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="alamat" class="col-form-label">Alamat</label>
                    </div>
                    <div class="col-7">
                        <input type="text" name="alamat" id="alamatedit" maxlength = "100" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Alamat"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-alamatedit"></div>
                </div>

                <div class="mt-3" style="margin-bottom: 20%"></div>
                <div class="d-flex justify-content-center mb-4">

                    <input type="submit" id="editkonsumen" class="btn shadow rounded"
                        style="background-color: #364F6B; color: white; width: 125px" value="Edit">
                </div>
            </div>
            <input type="hidden" name="idedit" id="idedit">
        </div>
    </div>
</div>

<script>
    $('#telpedit').on('keyup', function(e) {
        $(this).val(formatAngka($(this).val()));
    });
    $('#Editkonsumen').on('show.bs.modal', function(e) {
        var idkons = $(e.relatedTarget).data('id').idkons;
        var nama = $(e.relatedTarget).data('id').nama;
        var telp = $(e.relatedTarget).data('id').telp;
        var alamat = $(e.relatedTarget).data('id').alamat;
        $(e.currentTarget).find('input[id="idedit"]').val(idkons);
        $(e.currentTarget).find('input[id="namaedit"]').val(nama);
        $(e.currentTarget).find('input[id="telpedit"]').val(telp);
        $(e.currentTarget).find('input[id="alamatedit"]').val(alamat);
    });
    $('#editkonsumen').click(function(e) {
        e.preventDefault();

        let id = $('#idedit').val();
        let nama = $('#namaedit').val();
        let telp = $('#telpedit').val();
        let alamat = $('#alamatedit').val();
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: "/editkonsumen",
            data: {
                "id": id,
                "nama": nama,
                "telp": telp,
                "alamat": alamat,
                "_token": token
            },
            success: function(response) {
                search(1);
                $('#Editkonsumen').modal('hide');
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

                if (error.responseJSON.telp && error.responseJSON.telp[0]) {
                    //show alert
                    $('#alert-telpedit').removeClass('d-none');
                    $('#alert-telpedit').addClass('d-block');
                    //add message to alert
                    $('#alert-telpedit').html(error.responseJSON.telp[0]);
                } else {
                    $('#alert-telpedit').removeClass('d-block');
                    $('#alert-telpedit').addClass('d-none');
                }

                if (error.responseJSON.alamat && error.responseJSON.alamat[0]) {
                    //show alert
                    $('#alert-alamatedit').removeClass('d-none');
                    $('#alert-alamatedit').addClass('d-block');
                    //add message to alert
                    $('#alert-alamatedit').html(error.responseJSON.alamat[0]);
                } else {
                    $('#alert-alamatedit').removeClass('d-block');
                    $('#alert-alamatedit').addClass('d-none');
                }

            }
        });
    });
    $('#Editkonsumen').on('hidden.bs.modal', function() {
        $('#namaedit').val("");
        $('#telpedit').val("");
        $('#alamatedit').val("");
        $('#alert-namaedit').removeClass('d-block');
        $('#alert-namaedit').addClass('d-none');
        $('#alert-telpedit').removeClass('d-block');
        $('#alert-telpedit').addClass('d-none');
        $('#alert-alamatedit').removeClass('d-block');
        $('#alert-alamatedit').addClass('d-none');
    });
</script>
