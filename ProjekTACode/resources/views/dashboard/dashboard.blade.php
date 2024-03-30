<div class="col-10 my-3 offset-1">
    <div class="row">
        <div class="col-8 me-auto" style="border-right: 1px solid black">
            <div class="row align-items-center mb-2">
                <div class="col-4">
                    <p class="display-6 fw-bold">Dashboard</p>
                </div>
                <div class="col-4 ms-auto">
                    <div class="row align-items-center">
                        From <input type="date" id="tanggal1" class="form-control me-2 ms-2" style="width: 45px">
                        To<input type="date" id="tanggal2" class="form-control me-2 ms-2" style="width: 45px">
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-4">
                <div class="col-5">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
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
            <div class="row d-flex justify-content-center mt-4">
                <div class="col-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Kategori Terlaris</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
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
                        <div class="card-body" id="search2">

                        </div>
                    </div>
                </div>
                <div class="col-5 ms-auto me-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Produk Terlaris</h6>
                        </div>
                        <div class="card-body" id="search3">

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
    var myNewChart;
    var ctx = $('#myChart');
    $(document).ready(function() {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);
        $('#tanggal1').val(today);
        $('#tanggal2').val(today);

        $("#tanggal1, #tanggal2").change(function() {
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
        var tgl1 = $("#tanggal1").val();
        var tgl2 = $("#tanggal2").val();
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
        var tgl1 = $("#tanggal1").val();
        var tgl2 = $("#tanggal2").val();
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
        var tgl1 = $("#tanggal1").val();
        var tgl2 = $("#tanggal2").val();
        $.ajax({
            type: "get",
            url: "{{ url('/ajaxpendapatan') }}",
            data: {
                tgl1: tgl1,
                tgl2: tgl2
            },
            success: function(response) {
                $("#totalpenjualan").text(response.result);
            }
        });
    }

    function chart() {
        $.ajax({
            type: "GET",
            url: "{{ url('/chart') }}",
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
                            label: 'Kategori Terlaris',
                            data: data,

                        }]
                    },
                    options: {
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
        // Lakukan request untuk drill down ke subkategori berdasarkan kategori yang dipilih
        $.ajax({
            type: "GET",
            url: "{{ url('/subchart') }}",
            data: {
                category: category
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
                myNewChart.update();
            },
            error: function(xhr) {
                console.log(xhr.responseJSON);
            }
        });
    }
</script>
