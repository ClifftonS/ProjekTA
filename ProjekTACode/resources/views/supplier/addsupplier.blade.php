<div class="modal fade" id="Addsupplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Tambah Supplier
                </h5>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="nama" class="col-form-label">Nama</label>
                    </div>
                    <div class="col-7">
                        <input type="text" name="nama" id="namaadd" maxlength = "100" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Nama"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-namaadd"></div>
                </div>
                <div class="mt-0"></div>
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="telp" class="col-form-label">No Telp</label>
                    </div>
                    <div class="col-7">
                        <input type="text" name="telp" id="telpadd" maxlength = "15" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan NoTelp"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-telpadd"></div>
                </div>

                <div class="mt-3" style="margin-bottom: 20%"></div>
                <div class="d-flex justify-content-center mb-4">

                    <input type="submit" id="addsupplier" class="btn shadow rounded"
                        style="background-color: #364F6B; color: white; width: 125px" value="Tambah">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#telpadd').on('keyup', function(e) {
        $(this).val(formatAngka($(this).val()));
    });
    $('#addsupplier').click(function(e) {
        e.preventDefault();

        let nama = $('#namaadd').val();
        let telp = $('#telpadd').val();
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: "/addsupplier",
            data: {
                "nama": nama,
                "telp": telp,
                "_token": token
            },
            success: function(response) {
                search();
                $('#Addsupplier').modal('hide');
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

                if (error.responseJSON.telp && error.responseJSON.telp[0]) {
                    //show alert
                    $('#alert-telpadd').removeClass('d-none');
                    $('#alert-telpadd').addClass('d-block');
                    //add message to alert
                    $('#alert-telpadd').html(error.responseJSON.telp[0]);
                } else {
                    $('#alert-telpadd').removeClass('d-block');
                    $('#alert-telpadd').addClass('d-none');
                }

            }
        });
    });
    $('#Addsupplier').on('hidden.bs.modal', function() {
        $('#namaadd').val("");
        $('#telpadd').val("");
        $('#alert-namaadd').removeClass('d-block');
        $('#alert-namaadd').addClass('d-none');
        $('#alert-telpadd').removeClass('d-block');
        $('#alert-telpadd').addClass('d-none');
    });
</script>
