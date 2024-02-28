<div class="modal fade" id="Editpembelian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="produkedit" class="col-form-label">Produk</label>
                    </div>
                    <div class="col-7">
                        <select class="form-select" id="produkedit" name="produk" style=""required>
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-produkedit"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="tanggaledit" class="col-form-label">Tanggal Pembelian</label>
                    </div>
                    <div class="col-7">
                        <input type="date" id="tanggaledit" name="tanggaladd" required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-tanggaledit"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="qtyedit" class="col-form-label">Kuantitas</label>
                    </div>
                    <div class="col-7">
                        <input type="number" name="qtyadd" id="qtyedit" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Kuantitas"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-qtyedit"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="hargaedit" class="col-form-label">Harga Satuan</label>
                    </div>
                    <div class="col-7">
                        <input type="text" name="hargaadd" id="hargaedit" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Kuantitas"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-hargaedit"></div>
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
    $('#Editpembelian').on('show.bs.modal', function(e) {
        var idpembelian = $(e.relatedTarget).data('id').idpembelian;
        var idproduk = $(e.relatedTarget).data('id').idproduk;
        var qty = $(e.relatedTarget).data('id').qty;
        var harga = $(e.relatedTarget).data('id').harga;
        var tanggal = $(e.relatedTarget).data('id').tanggal;
        $(e.currentTarget).find('input[id="idedit"]').val(idpembelian);
        $(e.currentTarget).find('input[id="tanggaledit"]').val(tanggal);
        $(e.currentTarget).find('input[id="qtyedit"]').val(qty);
        $(e.currentTarget).find('input[id="hargaedit"]').val(harga);

        $.ajax({
            type: "get",
            url: "{{ url('/ajaxpembelianadd') }}",
            success: function(response) {
                var produkSelect = $(
                    '<select class="form-select" id="produkadd" name="produk" style=""required>'
                );

                if (response.produk.length == 0) {
                    produkSelect.append('<option value="kosong">Tidak ada Produk</option>');
                } else {
                    $.each(response.produk, function(index, produkoption) {
                        produkSelect.append(
                            `<option value="${produkoption.id_produk}">${produkoption.nama_produk}</option>`
                        );
                    });
                }

                $('#produkedit').replaceWith(merkSelect);
                $("#produkedit option[value='" + idproduk + "']").attr('selected', true);
            }
        });
    });
    $('#editpembelian').click(function(e) {
        e.preventDefault();

        let idpembelian = $('#idedit').val();
        let produk = $('#produkedit').val();
        let tanggal = $('#tanggaledit').val();
        let qty = $('#qtyedit').val();
        let harga = $('#hargaedit').val();
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: "/editpembelian",
            data: {
                "id": id,
                "produk": produk,
                "tanggal": tanggal,
                "qty": qty,
                "harga": harga,
                "_token": token
            },
            success: function(response) {
                search();
                $('#Editpembelian').modal('hide');
                Swal.fire({
                    title: "Success",
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 2000
                });
            },
            error: function(error) {

                if (error.responseJSON.produk && error.responseJSON.produk[0]) {
                    //show alert
                    $('#alert-produkedit').removeClass('d-none');
                    $('#alert-produkedit').addClass('d-block');
                    //add message to alert
                    $('#alert-produkedit').html(error.responseJSON.produk[0]);
                } else {
                    $('#alert-produkedit').removeClass('d-block');
                    $('#alert-produkedit').addClass('d-none');
                }

                if (error.responseJSON.tanggal && error.responseJSON.tanggal[0]) {
                    //show alert
                    $('#alert-tanggaledit').removeClass('d-none');
                    $('#alert-tanggaledit').addClass('d-block');
                    //add message to alert
                    $('#alert-tanggaledit').html(error.responseJSON.tanggal[0]);
                } else {
                    $('#alert-tanggaledit').removeClass('d-block');
                    $('#alert-tanggaledit').addClass('d-none');
                }

                if (error.responseJSON.qty && error.responseJSON.qty[0]) {
                    //show alert
                    $('#alert-qtyedit').removeClass('d-none');
                    $('#alert-qtyedit').addClass('d-block');
                    //add message to alert
                    $('#alert-qtyedit').html(error.responseJSON.qty[0]);
                } else {
                    $('#alert-qtyedit').removeClass('d-block');
                    $('#alert-qtyedit').addClass('d-none');
                }

                if (error.responseJSON.harga && error.responseJSON.harga[0]) {
                    //show alert
                    $('#alert-hargaedit').removeClass('d-none');
                    $('#alert-hargaedit').addClass('d-block');
                    //add message to alert
                    $('#alert-hargaedit').html(error.responseJSON.harga[0]);
                } else {
                    $('#alert-hargaedit').removeClass('d-block');
                    $('#alert-hargaedit').addClass('d-none');
                }

            }
        });
    });
    $('#Editpembelian').on('hidden.bs.modal', function() {
        $('#alert-produkedit').removeClass('d-block');
        $('#alert-produkedit').addClass('d-none');
        $('#alert-tanggaledit').removeClass('d-block');
        $('#alert-tanggaledit').addClass('d-none');
        $('#alert-qtyedit').removeClass('d-block');
        $('#alert-qtyedit').addClass('d-none');
        $('#alert-hargaedit').removeClass('d-block');
        $('#alert-hargaedit').addClass('d-none');
    });
</script>
