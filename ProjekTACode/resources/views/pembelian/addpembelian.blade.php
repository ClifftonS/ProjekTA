<div class="modal fade" id="Addpembelian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Tambah Transaksi
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
                        <label for="tanggaladd" class="col-form-label">Tanggal Pembelian</label>
                    </div>
                    <div class="col-7">
                        <input type="date" id="tanggaladd" name="tanggaladd" required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-tanggaladd"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="qtyadd" class="col-form-label">Kuantitas</label>
                    </div>
                    <div class="col-7">
                        <input type="number" name="qtyadd" id="qtyadd" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Kuantitas"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-qtyadd"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="hargaadd" class="col-form-label">Harga Satuan</label>
                    </div>
                    <div class="col-7">
                        <input type="text" name="hargaadd" id="hargaadd" class="form-control"
                            style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Kuantitas"
                            required>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-hargaadd"></div>
                </div>

                <div class="mt-3" style="margin-bottom: 20%"></div>
                <div class="d-flex justify-content-center mb-4">

                    <input type="submit" id="addpembelian" class="btn shadow rounded"
                        style="background-color: #364F6B; color: white; width: 125px" value="Tambah">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#hargaadd').on('keyup', function(e) {
        $(this).val(formatRupiah($(this).val()));
    });
    $('#Addpembelian').on('show.bs.modal', function(e) {
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
                $('#produkadd').replaceWith(produkSelect);

            }
        });
    });
    $('#addpembelian').click(function(e) {
        e.preventDefault();

        let produk = $('#namaproduk').val();
        let tanggal = $('#tanggaladd').val();
        let qty = $('#qtyadd').val();
        let harga = $('#hargaadd').val();
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: "POST",
            url: "/addpembelian",
            data: {
                "produk": produk,
                "tanggal": tanggal,
                "qty": qty,
                "harga": harga,
                "_token": token
            },
            success: function(response) {
                search();
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

                if (error.responseJSON.produk && error.responseJSON.produk[0]) {
                    //show alert
                    $('#alert-produkadd').removeClass('d-none');
                    $('#alert-produkadd').addClass('d-block');
                    //add message to alert
                    $('#alert-produkadd').html(error.responseJSON.produk[0]);
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

                if (error.responseJSON.qty && error.responseJSON.qty[0]) {
                    //show alert
                    $('#alert-qtyadd').removeClass('d-none');
                    $('#alert-qtyadd').addClass('d-block');
                    //add message to alert
                    $('#alert-qtyadd').html(error.responseJSON.qty[0]);
                } else {
                    $('#alert-qtyadd').removeClass('d-block');
                    $('#alert-qtyadd').addClass('d-none');
                }

                if (error.responseJSON.harga && error.responseJSON.harga[0]) {
                    //show alert
                    $('#alert-hargaadd').removeClass('d-none');
                    $('#alert-hargaadd').addClass('d-block');
                    //add message to alert
                    $('#alert-hargaadd').html(error.responseJSON.harga[0]);
                } else {
                    $('#alert-hargaadd').removeClass('d-block');
                    $('#alert-hargaadd').addClass('d-none');
                }

            }
        });
    });
    $('#Addpembelian').on('hidden.bs.modal', function() {
        $('#produkadd').val("");
        $('#tanggaladd').val("");
        $('#qtyadd').val("");
        $('#hargaadd').val("");
        $('#alert-produkadd').removeClass('d-block');
        $('#alert-produkadd').addClass('d-none');
        $('#alert-tanggaladd').removeClass('d-block');
        $('#alert-tanggaladd').addClass('d-none');
        $('#alert-qtyadd').removeClass('d-block');
        $('#alert-qtyadd').addClass('d-none');
        $('#alert-hargaadd').removeClass('d-block');
        $('#alert-hargaadd').addClass('d-none');
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
