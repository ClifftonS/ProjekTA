<div class="modal fade" id="Lihatpembelian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Lihat Transaksi
                </h5>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="supplierlihat" class="col-form-label">Konsumen</label>
                    </div>
                    <div class="col-7">
                        <select class="form-select" id="supplierlihat" name="produk" style="" disabled>
                        </select>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-supplierlihat"></div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row">
                    <div class="col-3">
                        <label for="tanggallihat" class="col-form-label">Tanggal Penjualan</label>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="input-group date" id="datepicker">
                            <input type="text" id="tanggallihat" class="form-control" readonly>
                            <span class="input-group-append">
                                <span class="input-group-text bg-white d-block">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-2">
                    <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-tanggallihat"></div>
                </div>


                <div class="row g-1 d-flex justify-content-center margin-row isiproduk">
                    <div class="col-4 text-center">
                        <label for="produklihat1" class="col-form-label">Produk</label>
                        <select class="form-select" id="produklihat1" name="produklihat1" style="" disabled>
                        </select>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-produklihat1">
                            </div>
                        </div>
                    </div>
                    <div class="col-2 text-center">
                        <label for="qtylihat1" class="col-form-label">Kuantitas</label>
                        <input type="number" name="qtylihat1" id="qtylihat1" min="1"
                            class="form-control hitungTotal" readonly>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-qtylihat1"></div>
                        </div>
                    </div>
                    <div class="col-3 text-center">
                        <label for="hargalihat1" class="col-form-label">Harga</label>
                        <input type="text" name="hargalihat1" id="hargalihat1" class="form-control hitungTotal"
                            readonly>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-hargalihat1">
                            </div>
                        </div>
                    </div>
                    <div class="col-3 text-center">
                        <label for="subtotallihat1" class="col-form-label">Subtotal</label>
                        <input type="text" name="subtotallihat1" id="subtotallihat1" class="form-control" readonly>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-subtotallihat1">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-1 d-flex justify-content-center margin-row plrow">
                </div>

                <div class="row g-1 mt-2 d-flex justify-content-end margin-row">
                    <div class="col-3 d-flex justify-content-center">
                        <label class="col-form-label">Total</label>
                    </div>
                    <div class="col-3">
                        <input type="text" id="totallihat" class="form-control" readonly>
                    </div>
                </div>

                <div class="mt-4"></div>
                <div class="d-flex justify-content-center mb-4">

                    <a id="cetakNota" onclick="openInNewTab(this.href); return false;"><button
                            class="btn shadow rounded"
                            style="background-color: #364F6B; color: white; width: 125px">Cetak Nota</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function openInNewTab(url) {
        var win = window.open(url, '_blank');
        win.focus(); // Fokuskan pada tab baru
        win.print();
    }
    var idpembelian = "";
    var total = 0;
    $('#Lihatpembelian').on('show.bs.modal', function(e) {
        idpembelian = $(e.relatedTarget).data('id').idpembelian;
        var href = '/cetaknota/' + idpembelian;
        $('#cetakNota').attr('href', href);
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxpenjualanlihat') }}",
            data: {
                "id": idpembelian
            },
            success: function(response) {
                if (response.detail.length > 1) {
                    for (var i = 2; i <= response.detail.length; i++) {
                        var newRow = `
                <div class="row g-1 d-flex justify-content-center margin-row deleteRow">
                    <div class="col-4 text-center">
                        <select class="form-select" id="produklihat${i}" name="produk" style="" disabled>
                        </select>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-produkadd1"></div>
                        </div>
                    </div>
                    <div class="col-2 text-center">
                        <input type="number" name="qtylihat${i}" id="qtylihat${i}" min="1" class="form-control hitungTotal"
                             readonly>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-qtyadd1"></div>
                        </div>
                    </div>
                    <div class="col-3 text-center">
                        <input type="text" name="hargalihat${i}" id="hargalihat${i}" class="form-control hitungTotal"
                             readonly>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-hargaadd1"></div>
                        </div>
                    </div>
                    <div class="col-3 text-center">
                        <input type="text" name="subtotallihat${i}" id="subtotallihat${i}" class="form-control"
                        readonly>
                        <div class="row d-flex justify-content-center mt-2">
                            <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-subtotaladd1">
                            </div>
                        </div>
                    </div>
                </div>
            `;

                        $('.plrow').before(newRow);
                    }
                }

                var supplierSelect = $(
                    '<select class="form-select" id="supplierlihat" name="produk" style="" disabled>'
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

                $('#supplierlihat').replaceWith(supplierSelect);
                $('#supplierlihat').val(response.detail[0].id_konsumen);
                var tanggalAwal = response.detail[0].tanggal_penjualan;
                var parts = tanggalAwal.split('-');
                var dd = parts[2];
                var mm = parts[1];
                var yyyy = parts[0];
                var tanggalFormatted = dd + '-' + mm + '-' + yyyy;
                $('#tanggallihat').val(tanggalFormatted);
                for (var j = 1; j <= response.detail.length; j++) {
                    var produkSelect = $(
                        '<select class="form-select" id="produklihat' + j +
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
                    $('#produklihat' + j + '').replaceWith(produkSelect);
                    $('#produklihat' + j + '').val(response.detail[j - 1].id_produk);
                    $('#hargalihat' + j + '').val(response.detail[j - 1].harga_detail);
                    $('#qtylihat' + j + '').val(response.detail[j - 1].qty_detail);
                    var harga = $('#hargalihat' + j + '').val();
                    var qty = $('#qtylihat' + j + '').val();
                    var subtotal = harga * qty;
                    $('#subtotallihat' + j + '').val(subtotal);
                    total += subtotal;
                    console.log(produkSelect);
                }
                $('#totallihat').val(total);

            }
        });
    });
    $('#Lihatpembelian').on('hidden.bs.modal', function() {
        $('#tanggallihat').val("");
        $('#qtylihat1').val("");
        $('#hargalihat1').val("");
        $('#alert-produkadd1').removeClass('d-block');
        $('#alert-produkadd1').addClass('d-none');
        $('#alert-tanggaladd').removeClass('d-block');
        $('#alert-tanggaladd').addClass('d-none');
        $('#alert-qtyadd1').removeClass('d-block');
        $('#alert-qtyadd1').addClass('d-none');
        $('#alert-hargaadd1').removeClass('d-block');
        $('#alert-hargaadd1').addClass('d-none');
        $('.deleteRow').remove();
        idpembelian = "";
        total = 0;
    });
</script>
