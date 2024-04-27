<div class="modal fade" id="Editkategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Edit Kategori
                </h5>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="nama" class="col-form-label">Kategori</label>
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

                <div class="mt-3" style="margin-bottom: 20%"></div>
                <div class="d-flex justify-content-center mb-4">

                    <input type="submit" id="editkategori" class="btn shadow rounded"
                        style="background-color: #364F6B; color: white; width: 125px" value="Edit">
                </div>
            </div>
            <input type="hidden" name="idedit" id="idedit">
        </div>
    </div>
</div>

<script>
    $('#Editkategori').on('show.bs.modal', function(e) {
        var idkategori = $(e.relatedTarget).data('id').idkategori;
        var nama = $(e.relatedTarget).data('id').kategori;
        $(e.currentTarget).find('input[id="idedit"]').val(idkategori);
        $(e.currentTarget).find('input[id="namaedit"]').val(nama);
    });
    $('#editkategori').click(function(e) {
        e.preventDefault();

        let id = $('#idedit').val();
        let nama = $('#namaedit').val();
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: "/editkategori",
            data: {
                "id": id,
                "nama": nama,
                "_token": token
            },
            success: function(response) {
                search(1);
                $('#Editkategori').modal('hide');
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

            }
        });
    });
    $('#Editkategori').on('hidden.bs.modal', function() {
        $('#namaedit').val("");
        $('#alert-namaedit').removeClass('d-block');
        $('#alert-namaedit').addClass('d-none');
    });
</script>
