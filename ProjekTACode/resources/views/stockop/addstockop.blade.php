<div class="modal fade" id="Addstockop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Tambah Stock Opname
                </h5>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="produkadd" class="col-form-label">Produk</label>
                    </div>
                    <div class="col-7">
                        <select class="form-select" id="produkadd" name="produk" style=""required>
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-produkadd"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="tanggaladd" class="col-form-label">Tanggal</label>
                    </div>
                    <div class="col-7 align-self-center">
                        <input type="date" id="tanggaladd" class="form-control">
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-tanggaladd"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="stokaddsistem" class="col-form-label">Stok Sistem</label>
                    </div>
                    <div class="col-7">
                        <input type="number" name="stok" id="stokaddsistem" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" readonly>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-stokadd2"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="stokadd" class="col-form-label">Stok Hitung</label>
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

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="keterangan" class="col-form-label">Keterangan</label>
                    </div>
                    <div class="col-7">
                        <input type="text" name="nama" id="keteranganadd" maxlength = "50" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Keterangan"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-keteranganadd"></div>
                </div>


                <div class="mt-3" style="margin-bottom: 20%"></div>
                <div class="d-flex justify-content-center mb-4">

                    <input type="submit" id="addstockop" class="btn shadow rounded"
                        style="background-color: #364F6B; color: white; width: 125px" value="Tambah">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('change', '#produkadd', function() {
        stoksistem();
    });
    $('#Addstockop').on('show.bs.modal', function(e) {
        setdate()
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxstockopadd') }}",
            success: function(response) {
                var produkSelect = $(
                    '<select class="form-select" id="produkadd" name="produk" style="" required>'
                );

                if (response.produk.length == 0) {
                    produkSelect.append('<option value="kosong">Tidak ada produk</option>');
                } else {
                    $.each(response.produk, function(index, produkoption) {
                        produkSelect.append(
                            `<option value="${produkoption.id_produk}">${produkoption.nama_produk}</option>`
                        );
                    });
                }

                $('#produkadd').replaceWith(produkSelect);
                stoksistem();

            }
        });
    });
    $('#addstockop').click(function(e) {
        e.preventDefault();
        let nama = $('#produkadd').val();
        let tanggal = $('#tanggaladd').val();
        let stok = $('#stokadd').val();
        let stoksistem = $('#stokaddsistem').val();
        let ket = $('#keteranganadd').val();
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: "/addstockop",
            data: {
                "nama": nama,
                "tanggal": tanggal,
                "stok": stok,
                "stoksistem": stoksistem,
                "ket": ket,
                "_token": token
            },
            success: function(response) {
                search();
                $('#Addstockop').modal('hide');
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
                    $('#alert-produkadd').removeClass('d-none');
                    $('#alert-produkadd').addClass('d-block');
                    //add message to alert
                    $('#alert-produkadd').html(error.responseJSON.nama[0]);
                } else {
                    $('#alert-produkadd').removeClass('d-block');
                    $('#alert-produkadd').addClass('d-none');
                }
                if (error.responseJSON.tanggal && error.responseJSON.tanggal[0]) {
                    //show alert
                    $('#alert-tanggaladd').removeClass('d-none');
                    $('#alert-tanggaladd').addClass('d-block');
                    //add message to alert
                    $('#alert-tanggaladd').html(error.responseJSON.tanggal[0]);
                } else {
                    $('#alert-tanggaladd').removeClass('d-block');
                    $('#alert-tanggaladd').addClass('d-none');
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
                if (error.responseJSON.ket && error.responseJSON.ket[0]) {
                    //show alert
                    $('#alert-keteranganadd').removeClass('d-none');
                    $('#alert-keteranganadd').addClass('d-block');
                    //add message to alert
                    $('#alert-keteranganadd').html(error.responseJSON.ket[0]);
                } else {
                    $('#alert-keteranganadd').removeClass('d-block');
                    $('#alert-keteranganadd').addClass('d-none');
                }
            }
        });
    });
    $('#Addstockop').on('hidden.bs.modal', function() {
        $('#produkadd').val("");
        $('#stoksistemadd').val("");
        $('#stokadd').val("");
        $('#keteranganadd').val("");
        $('#tanggaladd').val("");
        $('#alert-produkadd').removeClass('d-block');
        $('#alert-produkadd').addClass('d-none');
        $('#alert-tanggaladd').removeClass('d-block');
        $('#alert-tanggaladd').addClass('d-none');
        $('#alert-stokadd').removeClass('d-block');
        $('#alert-stokadd').addClass('d-none');
        $('#alert-keteranganadd').removeClass('d-block');
        $('#alert-keteranganadd').addClass('d-none');
    });

    function setdate() {
        var now = new Date();

        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);

        var today = now.getFullYear() + "-" + (month) + "-" + (day);

        $('#tanggaladd').val(today);
    }

    function stoksistem() {
        let id = $('#produkadd').val();
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxstockopaddstok') }}",
            data: {
                "id": id
            },
            success: function(response) {
                $('#stokaddsistem').val(response.stok);
            }
        });
    }
</script>
