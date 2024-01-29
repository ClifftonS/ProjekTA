<div class="modal fade" id="Addkonsumen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center justify-content-center">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Konsumen
                </h5>
            </div>

            <div class="modal-body">
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="nama" class="col-form-label">Nama</label>
                    </div>
                    <div class="col-7">
                        <input type="text" name="nama" id="nama" maxlength = "100" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Nama"
                            required>
                    </div>
                </div>
                <div class="mt-4"></div>
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="telp" class="col-form-label">No Telp</label>
                    </div>
                    <div class="col-7">
                        <input type="text" name="telp" id="telp" maxlength = "15" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan NoTelp"
                            required>
                    </div>
                </div>
                <div class="mt-4"></div>
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="alamat" class="col-form-label">Alamat</label>
                    </div>
                    <div class="col-7">
                        <input type="text" name="alamat" id="alamat" maxlength = "100" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Alamat"
                            required>
                    </div>
                </div>

                <div class="mt-3" style="margin-bottom: 20%"></div>
                <div class="d-flex justify-content-center mb-4">

                    <input type="submit" id="add" class="btn shadow rounded"
                        style="background-color: #364F6B; color: white; width: 125px" value="Tambah">
                </div>
            </div>
            {{-- <div class="modal-footer d-flex justify-content-center">
                </div> --}}
            <button type="button" class="btn-close position-absolute top-0 end-0 mx-auto" aria-label="Close"
                data-bs-dismiss="modal"></button>

        </div>
    </div>
</div>

<script type="text/javascript">
    $('#add').click(function(e) {
        e.preventDefault();

        let nama = $('#nama').val();
        let telp = $('#telp').val();
        let alamat = $('#alamat').val();
        let token = $("meta[name='csrf-token']").attr("content");

        $.ajax({

            url: "{{ url('/addkonsumen') }}",
            type: "POST",
            data: {
                "nama": nama,
                "telp": telp,
                "alamat": alamat,
                "_token": token
            },
            success: function(response) {
                search();
                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });


            }

        });

    });
</script>
