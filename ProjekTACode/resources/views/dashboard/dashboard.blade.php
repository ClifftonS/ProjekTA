<div class="col-10 my-3 offset-1">
    <div class="row">
        <div class="col-8 me-auto" style="border-right: 1px solid black">
            <div class="row align-items-center mb-2">
                <div class="col-4">
                    <p class="display-6 fw-bold">Dashboard</p>
                </div>
                <div class="col-5 ms-auto me-5">
                    <div class="row">
                        <input class="ms-auto" type="text" id="daterange" name="daterange" style="width: 240px"
                            readonly />
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-4">
                <div class="col-5 me-5">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Pendapatan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <span
                                            id="totalpenjualan"></span></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mt-4">
                <div class="col-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Konsumen Terloyal</h6>
                        </div>
                        <div class="card-body text-center" id="search2">

                        </div>
                    </div>
                </div>
                <div class="col-5 ms-auto me-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Produk Terlaris</h6>
                        </div>
                        <div class="card-body text-center" id="search3">

                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-center mt-2">
                <div class="col-10 me-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Kategori Terlaris</h6>
                        </div>
                        <div class="card-body">
                            <button onclick="chart()" id="backButton" class="btn btn-secondary btn-sm"
                                style="display: none;">Kembali</button>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Stok Menipis</h6>
                </div>
                <div class="card-body" id="search1">

                </div>
            </div>
            {{-- <div class="search d-flex justify-content-center" id="search1"></div> --}}
        </div>
    </div>
</div>

<script>
    var ctx = $('#myChart');
    var config = {
        type: 'pie'
    };
    var myNewChart = new Chart(ctx, config);
    $(document).ready(function() {
        var today = moment();
        $("#daterange").daterangepicker({
            autoUpdateInput: false,
            startDate: today,
            endDate: today
        });

        $("#daterange").val(today.format('DD-MM-YYYY') + ' s/d ' + today.format('DD-MM-YYYY'));

        $("#daterange").trigger('apply.daterangepicker');
        // Fungsi untuk menangani perubahan tanggal
        $("#daterange").on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' s/d ' + picker.endDate.format(
                'DD-MM-YYYY'));
            // Setelah tanggal diubah, kita perlu memanggil fungsi-fungsi yang bergantung pada tanggal
            search2();
            search3();
            search4();
            chart();
        });

        search1();
        search2();
        search3();
        search4();
        chart();
    });

    function search1() {
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxdashboardstok') }}",
            success: function(response) {
                $("#search1").html(response);
            }
        });
    }

    function search2() {
        var dates = $("#daterange").val().split(' s/d ');
        var tgl1 = dates[0];
        var tgl2 = dates[1];
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxkonsumenter') }}",
            data: {
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function(response) {
                $("#search2").html(response);
            }
        });
    }

    function search3() {
        var dates = $("#daterange").val().split(' s/d ');
        var tgl1 = dates[0];
        var tgl2 = dates[1];
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxprodukter') }}",
            data: {
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function(response) {
                $("#search3").html(response);
            }
        });
    }

    function search4() {
        var dates = $("#daterange").val().split(' s/d ');
        var tgl1 = dates[0];
        var tgl2 = dates[1];
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxpendapatan') }}",
            data: {
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function(response) {
                $("#totalpenjualan").text(parseFloat(response.result).toLocaleString('id-ID'));
            }
        });
    }

    function chart() {
        myNewChart.destroy();
        // myNewChart.options.events = ['click'];
        $('#backButton').css('display', 'none');
        var dates = $("#daterange").val().split(' s/d ');
        var tgl1 = dates[0];
        var tgl2 = dates[1];
        $.ajax({
            type: "GET",
            url: "{{ url('/chart') }}",
            data: {
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function(response) {
                var labels = response.data.map(function(e) {
                    return e.kategori
                })

                var data = response.data.map(function(e) {
                    return e.jumlah
                })

                var config = {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Produk Terjual',
                            data: data,

                        }]
                    },
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Kategori',
                                font: {
                                    weight: 'bold',
                                    size: 20
                                }
                            }
                        },
                        onClick: function(evt, item) {
                            // Mendapatkan kategori yang dipilih
                            var index = item[0].index;
                            var label = myNewChart.data.labels[index];
                            drillDown(label);
                        }

                    }
                };
                myNewChart = new Chart(ctx, config);
            },
            error: function(xhr) {
                console.log(xhr.responseJSON);
            }
        });
    }

    function drillDown(category) {
        myNewChart.options.events = ['mousemove'];
        // Lakukan request untuk drill down ke subkategori berdasarkan kategori yang dipilih
        var dates = $("#daterange").val().split(' s/d ');
        var tgl1 = dates[0];
        var tgl2 = dates[1];
        $.ajax({
            type: "GET",
            url: "{{ url('/subchart') }}",
            data: {
                category: category,
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function(response) {
                // Update pie chart dengan data subkategori

                var labels = response.data.map(function(e) {
                    return e.merk;
                });


                var data = response.data.map(function(e) {
                    return e.jumlah;
                });

                myNewChart.data.labels = labels;
                myNewChart.data.datasets[0].data = data;
                myNewChart.options.plugins.title.text = 'Merk';
                myNewChart.update();
                $('#backButton').css('display', 'block');
            },
            error: function(xhr) {
                console.log(xhr.responseJSON);
            }
        });
    }
</script>
