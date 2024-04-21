<div class="modal fade" id="Editretur" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Retur
                </h5>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="supplieredit" class="col-form-label">Konsumen</label>
                    </div>
                    <div class="col-7">
                        <select class="form-select" id="supplieredit" name="produk" style="">
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-supplieredit"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="tanggaledit" class="col-form-label">Tanggal Penjualan</label>
                    </div>
                    <div class="col-7 align-self-center">
                        <input type="date" id="tanggaledit" class="form-control">
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-tanggaledit"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center">
                    <div class="col-4 text-center">
                        <label for="produkedit1" class="col-form-label">Produk</label>
                    </div>
                    <div class="col-1 text-center">
                        <label class="col-form-label">Retur</label>
                    </div>
                    <div class="col-3 text-center">
                        <label class="col-form-label">Tanggal</label>
                    </div>
                    <div class="col-3 text-center">
                        <label for="qtyedit1" class="col-form-label">Keterangan</label>
                    </div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row plsrow">
                </div>

                <div class="mt-4"></div>
                <div class="d-flex justify-content-center mb-4">

                    <input type="submit" id="editpembelian" class="btn shadow rounded"
                        style="background-color: #364F6B; color: white; width: 125px" value="Edit">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var idpembelian = "";
    var totaledit = 0;

    $(document).on('change', 'input[type=checkbox][id^=cbretur]', function() {
        // Ambil indeks row dari id checkbox
        let index = $(this).attr('id').match(/\d+/)[0];
        // Ambil input keterangan berdasarkan indeks row
        let ketInput = $('#ket' + index);
        let dateInput = $('#date' + index);

        // Ubah status input keterangan berdasarkan status checkbox
        if ($(this).is(':checked')) {
            ketInput.prop('disabled', false); // Aktifkan input keterangan
            dateInput.prop('disabled', false);
            var now = new Date();

            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);

            var today = now.getFullYear() + "-" + (month) + "-" + (day);

            dateInput.val(today);
        } else {
            ketInput.prop('disabled', true); // Nonaktifkan input keterangan
            dateInput.prop('disabled', true);
        }
    });


    $('#Editretur').on('show.bs.modal', function(e) {
        idpembelian = $(e.relatedTarget).data('id').idpembelian;
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxpenjualanlihat') }}",
            data: {
                "id": idpembelian
            },
            success: function(response) {
                rowNumber = response.detail.length;

                for (var i = 1; i <= response.detail.length; i++) {
                    var newRow = `
                <div class="row g-1 d-flex justify-content-center margin-row deleteRow">
                    <div class="col-4 text-center">
                        <select class="form-select" id="produkedit${i}" name="produk" style="" disabled>
                        </select>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-produkedit1"></div>
                        </div>
                    </div>
                    <div class="col-1 d-flex justify-content-center align-items-center">
                        <div class="form-check">
                            
                            <label class="form-check-label d-flex justify-content-center align-items-center" for="flexCheckDefault">
                                <input class="form-check-input" data-toggle='collapse' data-target='#collapse${i}' type="checkbox" value="" id="cbretur${i}">
                                
                            </label>
                        </div>
                    </div>
                    <div class="col-3 text-center">
                        <input type="date" class="input form-control" id="date${i}" disabled>
                    </div>
                    <div class="col-3 text-center">
                        <input type="text" class="input form-control" id="ket${i}" disabled>
                    </div>
                </div>
            `;

                    $('.plsrow').before(newRow);
                }


                var supplierSelect = $(
                    '<select class="form-select" id="supplieredit" name="produk" style="" readonly>'
                );
                if (response.supplier.length == 0) {
                    supplierSelect.append('<option value="kosong">Tidak ada supplier</option>');
                } else {
                    $.each(response.supplier, function(index, supplieroption) {
                        supplierSelect.append(
                            `<option value="${supplieroption.id_konsumen}">${supplieroption.nama}</option>`
                        );
                    });
                }

                $('#supplieredit').replaceWith(supplierSelect);
                $('#supplieredit').val(response.detail[0].id_konsumen);
                $('#tanggaledit').val(response.detail[0].tanggal_penjualan);
                for (var j = 1; j <= response.detail.length; j++) {
                    var produkSelect = $(
                        '<select class="form-select" id="produkedit' + j +
                        '" name="produk" style="" disabled>'
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
                    $('#produkedit' + j + '').replaceWith(produkSelect);
                    $('#produkedit' + j + '').val(response.detail[j - 1].id_produk);
                    $('#qtyedit' + j + '').val(response.detail[j - 1].qty_detail);
                    if (response.detail[j - 1].ketretur != "" && response.detail[j - 1].ketretur !=
                        null) {
                        $('#ket' + j + '').val(response.detail[j - 1].ketretur);
                        $('#cbretur' + j + '').prop('checked', true);
                        $('#ket' + j + '').prop('disabled', false);
                        $('#date' + j + '').val(response.detail[j - 1].tglretur);
                        $('#date' + j + '').prop('disabled', false);
                    } else {
                        $('#date' + j + '').val("");
                    }
                    var qty = $('#qtyedit' + j + '').val();
                }

            }
        });
    });
    $('#editpembelian').click(function(e) {
        e.preventDefault();

        let token = $("meta[name='csrf-token']").attr("content");
        let dataisi = {
            "jumlahdata": rowNumber,
            "id": idpembelian,
            "_token": token
        };

        for (let i = 1; i <= rowNumber; i++) {
            dataisi['produk' + i] = $('#produkedit' + i).val();
            if ($('#cbretur' + i + '').prop('checked') == true) {
                dataisi['cek' + i] = 1;
                dataisi['date' + i] = $('#date' + i).val();
                dataisi['ket' + i] = $('#ket' + i).val();
            } else {
                dataisi['cek' + i] = 0;
            }
        }

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan mengubah retur barang ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, tambahkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mengirimkan data menggunakan AJAX jika dikonfirmasi
                $.ajax({
                    type: "POST",
                    url: "/editretur",
                    data: dataisi,
                    success: function(response) {
                        search();
                        $('#Editretur').modal('hide');
                        Swal.fire({
                            title: "Success",
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                    error: function(error) {

                        if (error.responseJSON.produk1 && error.responseJSON.produk1[0]) {
                            //show alert
                            $('#alert-produkedit1').removeClass('d-none');
                            $('#alert-produkedit1').addClass('d-block');
                            //add message to alert
                            $('#alert-produkedit1').html(error.responseJSON.produk1[0]);
                        } else {
                            $('#alert-produkedit1').removeClass('d-block');
                            $('#alert-produkedit1').addClass('d-none');
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

                        if (error.responseJSON.supplier && error.responseJSON.supplier[0]) {
                            //show alert
                            $('#alert-supplieredit').removeClass('d-none');
                            $('#alert-supplieredit').addClass('d-block');
                            //add message to alert
                            $('#alert-supplieredit').html(error.responseJSON.supplier[0]);
                        } else {
                            $('#alert-supplieredit').removeClass('d-block');
                            $('#alert-supplieredit').addClass('d-none');
                        }

                        if (error.responseJSON.qty1 && error.responseJSON.qty1[0]) {
                            //show alert
                            $('#alert-qtyedit1').removeClass('d-none');
                            $('#alert-qtyedit1').addClass('d-block');
                            //add message to alert
                            $('#alert-qtyedit1').html(error.responseJSON.qty1[0]);
                        } else {
                            $('#alert-qtyedit1').removeClass('d-block');
                            $('#alert-qtyedit1').addClass('d-none');
                        }

                        if (error.responseJSON.harga1 && error.responseJSON.harga1[0]) {
                            //show alert
                            $('#alert-hargaedit1').removeClass('d-none');
                            $('#alert-hargaedit1').addClass('d-block');
                            //add message to alert
                            $('#alert-hargaedit1').html(error.responseJSON.harga1[0]);
                        } else {
                            $('#alert-hargaedit1').removeClass('d-block');
                            $('#alert-hargaedit1').addClass('d-none');
                        }

                    }
                });
            }
        });
    });
    $('#Editretur').on('hidden.bs.modal', function() {
        $('#tanggaledit').val("");
        $('#qtyedit1').val("");
        $('#hargaedit1').val("");
        $('#alert-produkedit1').removeClass('d-block');
        $('#alert-produkedit1').addClass('d-none');
        $('#alert-tanggaledit').removeClass('d-block');
        $('#alert-tanggaledit').addClass('d-none');
        $('#alert-qtyedit1').removeClass('d-block');
        $('#alert-qtyedit1').addClass('d-none');
        $('#alert-hargaedit1').removeClass('d-block');
        $('#alert-hargaedit1').addClass('d-none');
        $('.deleteRow').remove();
        idpembelian = "";
        totaledit = 0;
        rowNumber = 0;
    });
</script>
