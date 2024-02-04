<div class="modal fade" id="Addkategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Tambah Kategori
                </h5>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="nama" class="col-form-label">Kategori</label>
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

                <div class="mt-3" style="margin-bottom: 20%"></div>
                <div class="d-flex justify-content-center mb-4">

                    <input type="submit" id="addkategori" class="btn shadow rounded"
                        style="background-color: #364F6B; color: white; width: 125px" value="Tambah">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#addkategori').click(function(e) {
        e.preventDefault();

        let nama = $('#namaadd').val();
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: "/addkategori",
            data: {
                "nama": nama,
                "_token": token
            },
            success: function(response) {
                search();
                $('#Addkategori').modal('hide');
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

            }
        });
    });
    $('#Addkategori').on('hidden.bs.modal', function() {
        $('#namaadd').val("");
        $('#alert-namaadd').removeClass('d-block');
        $('#alert-namaadd').addClass('d-none');
    });
</script>
