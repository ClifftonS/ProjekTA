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
                        <label for="supplieradd" class="col-form-label">Konsumen</label>
                    </div>
                    <div class="col-7">
                        <select class="form-select" id="supplieradd" name="produk" style=""required>
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-supplieradd"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="tanggaladd" class="col-form-label">Tanggal Penjualan</label>
                    </div>
                    <div class="col-7 align-self-center">
                        <input type="date" id="tanggaladd" class="form-control">
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-tanggaladd"></div>
                </div>


                <div class="row g-1 d-flex justify-content-center margin-row isiproduk">
                    <div class="col-4 text-center">
                        <label for="produkadd1" class="col-form-label">Produk</label>
                        <select class="form-select" id="produkadd1" name="produk" style=""required>
                        </select>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-produkadd1">
                            </div>
                        </div>
                    </div>
                    <div class="col-2 text-center">
                        <label for="qtyadd1" class="col-form-label">Kuantitas</label>
                        <input type="number" name="qtyadd1" id="qtyadd1" min="1"
                            class="form-control hitungTotal" required>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-qtyadd1"></div>
                        </div>
                    </div>
                    <div class="col-3 text-center">
                        <label for="hargaadd1" class="col-form-label">Harga</label>
                        <input type="text" name="hargaadd1" id="hargaadd1" class="form-control hitungTotal" required>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-hargaadd1"></div>
                        </div>
                    </div>
                    <div class="col-3 text-center">
                        <label for="subtotaladd1" class="col-form-label">Subtotal</label>
                        <input type="text" name="subtotaladd1" id="subtotaladd1" class="form-control" readonly>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-subtotaladd1">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row plusrow">
                    <div id="plus" class="d-flex align-items-center justify-content-center"><i
                            class="fa-solid fa-circle-plus fs-5"></i></div>
                </div>

                <div class="row g-1 mt-2 d-flex justify-content-end margin-row">
                    <div class="col-3 d-flex justify-content-center">
                        <label class="col-form-label">Total</label>
                    </div>
                    <div class="col-3">
                        <input type="text" id="totaladd" class="form-control" readonly>
                    </div>
                </div>

                <div class="mt-4"></div>
                <div class="d-flex justify-content-center mb-4">

                    <input type="submit" id="addpembelian" class="btn shadow rounded"
                        style="background-color: #364F6B; color: white; width: 125px" value="Tambah">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var rowNumber = 1;
    $('#plus').click(function() {
        rowNumber++; // Menambahkan nomor baris
        var newRow = `
                <div class="row g-1 d-flex justify-content-center margin-row deleteRow">
                    <div class="col-4 text-center">
                        <select class="form-select" id="produkadd${rowNumber}" name="produk" style="" required>
                        </select>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-produkadd1"></div>
                        </div>
                    </div>
                    <div class="col-2 text-center">
                        <input type="number" name="qtyadd${rowNumber}" id="qtyadd${rowNumber}" min="1" class="form-control hitungTotal"
                             required>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-qtyadd${rowNumber}"></div>
                        </div>
                    </div>
                    <div class="col-3 text-center">
                        <input type="text" name="hargaadd${rowNumber}" id="hargaadd${rowNumber}" class="form-control hitungTotal"
                             required>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-hargaadd1"></div>
                        </div>
                    </div>
                    <div class="col-3 text-center">
                        <input type="text" name="subtotaladd${rowNumber}" id="subtotaladd${rowNumber}" class="form-control"
                        readonly>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-subtotaladd1">
                            </div>
                        </div>
                    </div>
                </div>
            `;

        $('.plusrow').before(newRow);
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxpenjualanadd') }}",
            success: function(response) {
                var produkSelect = $(
                    '<select class="form-select" id= "produkadd' + rowNumber +
                    '" name="produk" style="" required>'
                );

                if (response.produk.length == 0) {
                    produkSelect.append('<option value="kosong">Tidak ada merk</option>');
                } else {
                    $.each(response.produk, function(index, produkoption) {
                        produkSelect.append(
                            `<option value="${produkoption.id_produk}">${produkoption.nama_produk}</option>`
                        );
                    });
                }

                $('#produkadd' + rowNumber + '').replaceWith(produkSelect);

            }
        });

    });
    $(document).on('input', '.hitungTotal', function() {
        var j = 1;
        var total = 0;
        for (j; j <= rowNumber; j++) {
            var harga = $('#hargaadd' + j + '').val();
            var hargaTanpaSeparator = harga.replace(/\./g, '');
            var formattedNumber = hargaTanpaSeparator.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            $('#hargaadd' + j + '').val(formattedNumber);
            var qty = $('#qtyadd' + j + '').val();
            var subtotal = hargaTanpaSeparator * qty;
            $('#subtotaladd' + j + '').val(parseFloat(subtotal)
                .toLocaleString('id-ID'));
            total += subtotal
        }
        $('#totaladd').val(parseFloat(total)
            .toLocaleString('id-ID'));
    });
    $(document).on('change', '#supplieradd', function() {
        tooltp();
    });
    $('#Addpembelian').on('show.bs.modal', function(e) {
        setdate()
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxpenjualanadd') }}",
            success: function(response) {
                var produkSelect = $(
                    '<select class="form-select" id="produkadd1" name="produk" style="" required>'
                );
                var supplierSelect = $(
                    '<select class="form-select" data-bs-toggle="tooltip" data-bs-placement="right" title="ppp" id="supplieradd" name="produk" style="" required>'
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
                if (response.supplier.length == 0) {
                    supplierSelect.append('<option value="kosong">Tidak ada supplier</option>');
                } else {
                    $.each(response.supplier, function(index, supplieroption) {
                        supplierSelect.append(
                            `<option value="${supplieroption.id_konsumen}">${supplieroption.nama}</option>`
                        );
                    });
                }

                $('#produkadd1').replaceWith(produkSelect);
                $('#supplieradd').replaceWith(supplierSelect);
                tooltp();
            }
        });
    });

    $('#addpembelian').click(function(e) {
        e.preventDefault();

        let supplier = $('#supplieradd').val();
        let tanggal = $('#tanggaladd').val();
        let totalsep = $('#totaladd').val();
        var total = totalsep.replace(/\./g, '');
        let token = $("meta[name='csrf-token']").attr("content");

        let dataisi = {
            "supplier": supplier,
            "total": total,
            "tanggal": tanggal,
            "jumlahdata": rowNumber,
            "_token": token
        };

        for (let i = 1; i <= rowNumber; i++) {
            dataisi['produk' + i] = $('#produkadd' + i).val();
            dataisi['qty' + i] = $('#qtyadd' + i).val();
            dataisi['harga' + i] = $('#hargaadd' + i).val().replace(/\./g, '');
        }

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menambahkan transaksi penjualan ini!",
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
                    url: "/addpenjualan",
                    data: dataisi,
                    success: function(response) {
                        search(1);
                        $('#Addpembelian').modal('hide');
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
                            $('#alert-produkadd1').removeClass('d-none');
                            $('#alert-produkadd1').addClass('d-block');
                            //add message to alert
                            $('#alert-produkadd1').html(error.responseJSON.produk1[0]);
                        } else {
                            $('#alert-produkadd1').removeClass('d-block');
                            $('#alert-produkadd1').addClass('d-none');
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

                        if (error.responseJSON.supplier && error.responseJSON.supplier[0]) {
                            //show alert
                            $('#alert-supplieradd').removeClass('d-none');
                            $('#alert-supplieradd').addClass('d-block');
                            //add message to alert
                            $('#alert-supplieradd').html(error.responseJSON.supplier[0]);
                        } else {
                            $('#alert-supplieradd').removeClass('d-block');
                            $('#alert-supplieradd').addClass('d-none');
                        }

                        for (var z = 1; z <= rowNumber; z++) {
                            var qtyField = 'qty' + z;
                            var alertElement = $('#alert-qtyadd' + z);

                            if (error.responseJSON[qtyField] && error.responseJSON[qtyField]
                                [0]) {
                                // Show alert for current qty field
                                alertElement.removeClass('d-none');
                                alertElement.addClass('d-block');
                                alertElement.html(error.responseJSON[qtyField][0]);
                            } else {
                                // Hide alert for current qty field
                                alertElement.removeClass('d-block');
                                alertElement.addClass('d-none');
                            }
                        }

                        // if (error.responseJSON.qty1 && error.responseJSON.qty1[0]) {
                        //     //show alert
                        //     $('#alert-qtyadd1').removeClass('d-none');
                        //     $('#alert-qtyadd1').addClass('d-block');
                        //     //add message to alert
                        //     $('#alert-qtyadd1').html(error.responseJSON.qty1[0]);
                        // } else {
                        //     $('#alert-qtyadd1').removeClass('d-block');
                        //     $('#alert-qtyadd1').addClass('d-none');
                        // }

                        if (error.responseJSON.harga1 && error.responseJSON.harga1[0]) {
                            //show alert
                            $('#alert-hargaadd1').removeClass('d-none');
                            $('#alert-hargaadd1').addClass('d-block');
                            //add message to alert
                            $('#alert-hargaadd1').html(error.responseJSON.harga1[0]);
                        } else {
                            $('#alert-hargaadd1').removeClass('d-block');
                            $('#alert-hargaadd1').addClass('d-none');
                        }

                    }
                });
            }
        });

    });
    $('#Addpembelian').on('hidden.bs.modal', function() {
        $('#tanggaladd').val("");
        $('#qtyadd1').val("");
        $('#hargaadd1').val("");
        $('#alert-produkadd1').removeClass('d-block');
        $('#alert-produkadd1').addClass('d-none');
        $('#alert-tanggaladd').removeClass('d-block');
        $('#alert-tanggaladd').addClass('d-none');
        $('#alert-qtyadd1').removeClass('d-block');
        $('#alert-qtyadd1').addClass('d-none');
        $('#alert-hargaadd1').removeClass('d-block');
        $('#alert-hargaadd1').addClass('d-none');
        $('.deleteRow').remove();
        rowNumber = 1;
    });

    function setdate() {
        var now = new Date();

        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);

        var today = now.getFullYear() + "-" + (month) + "-" + (day);

        $('#tanggaladd').val(today);
    }

    function tooltp() {
        let total = $('#supplieradd').val();
        $.ajax({
            type: "get",
            data: {
                "total": total
            },
            url: "{{ url('/ajaxtooltip') }}",
            success: function(response) {
                console.log(response.total);
                $("#supplieradd").tooltip('dispose');
                $('#supplieradd').attr('title', 'Pembelian ' + response.total +
                    ' transaksi');
                // Dispose the old tooltip
                $("#supplieradd").tooltip("show"); // Create a new tooltip
            }
        });
    }
</script>
