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
                        <select class="form-select" id="produkadd" name="merk" style=""required>
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
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-qtyadd"></div>
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
    $('#hargaadd').on('keyup', function(e) {
        $(this).val(formatRupiah($(this).val()));
    });
    $('#Addproduk').on('show.bs.modal', function(e) {
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxprodukadd') }}",
            success: function(response) {
                var merkSelect = $(
                    '<select class="form-select" id="merkadd" name="merk" style="" required>');

                var kategoriSelect = $(
                    '<select class="form-select" id="kategoriadd" name="kategori" style="" required>'
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
