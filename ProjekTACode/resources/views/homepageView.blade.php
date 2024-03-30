<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS Berkat Mulia</title>

    <link rel="stylesheet" href="{{ URL::asset('style.css') }}">
    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- Fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

</head>

<body>
    <div class="container-fluid g-0">
        <div class="row g-0">
            @include('sidebar')
            <div class="col-10 g-0" id="content">
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#dashboard').trigger('click');
        });
        $('#sidemaster').on('show.bs.collapse', function() {
            $(this).prev().find('.fa-caret-right').removeClass('fa-caret-right').addClass('fa-caret-down');
        });

        $('#sidemaster').on('hide.bs.collapse', function() {
            $(this).prev().find('.fa-caret-down').removeClass('fa-caret-down').addClass('fa-caret-right');
        });
        $('#sidetransaksi').on('show.bs.collapse', function() {
            $(this).prev().find('.fa-caret-right').removeClass('fa-caret-right').addClass('fa-caret-down');
        });

        $('#sidetransaksi').on('hide.bs.collapse', function() {
            $(this).prev().find('.fa-caret-down').removeClass('fa-caret-down').addClass('fa-caret-right');
        });

        $('#kategori').click(function(e) {
            e.preventDefault();

            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: "GET",
                url: "/kategori",
                data: {
                    "_token": token
                },
                success: function(response) {
                    if (response.redirect === "loginpage") {
                        window.location.href = "/loginpage";
                    } else {
                        $("#content").html(response);
                        $('.nav-link').removeClass('active');
                        $('#kategori').addClass('active');
                    }
                }
            });
        });
        $('#konsumen').click(function(e) {
            e.preventDefault();

            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: "GET",
                url: "/konsumen",
                data: {
                    "_token": token
                },
                success: function(response) {
                    if (response.redirect === "loginpage") {
                        window.location.href = "/loginpage";
                    } else {
                        $("#content").html(response);
                        $('.nav-link').removeClass('active');
                        $('#konsumen').addClass('active');
                    }
                }
            });
        });
        $('#supplier').click(function(e) {
            e.preventDefault();

            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: "GET",
                url: "/supplier",
                data: {
                    "_token": token
                },
                success: function(response) {
                    if (response.redirect === "loginpage") {
                        window.location.href = "/loginpage";
                    } else {
                        $("#content").html(response);
                        $('.nav-link').removeClass('active');
                        $('#supplier').addClass('active');
                    }
                }
            });
        });
        $('#merk').click(function(e) {
            e.preventDefault();

            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: "GET",
                url: "/merk",
                data: {
                    "_token": token
                },
                success: function(response) {
                    if (response.redirect === "loginpage") {
                        window.location.href = "/loginpage";
                    } else {
                        $("#content").html(response);
                        $('.nav-link').removeClass('active');
                        $('#merk').addClass('active');
                    }
                }
            });
        });
        $('#produk').click(function(e) {
            e.preventDefault();

            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: "GET",
                url: "/produk",
                data: {
                    "_token": token
                },
                success: function(response) {
                    if (response.redirect === "loginpage") {
                        window.location.href = "/loginpage";
                    } else {
                        $("#content").html(response);
                        $('.nav-link').removeClass('active');
                        $('#produk').addClass('active');
                    }
                }
            });
        });
        $('#penjualan').click(function(e) {
            e.preventDefault();

            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: "GET",
                url: "/penjualan",
                data: {
                    "_token": token
                },
                success: function(response) {
                    if (response.redirect === "loginpage") {
                        window.location.href = "/loginpage";
                    } else {
                        $("#content").html(response);
                        $('.nav-link').removeClass('active');
                        $('#penjualan').addClass('active');
                    }
                }
            });
        });
        $('#pembelian').click(function(e) {
            e.preventDefault();

            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: "GET",
                url: "/pembelian",
                data: {
                    "_token": token
                },
                success: function(response) {
                    if (response.redirect === "loginpage") {
                        window.location.href = "/loginpage";
                    } else {
                        $("#content").html(response);
                        $('.nav-link').removeClass('active');
                        $('#pembelian').addClass('active');
                    }
                }
            });
        });
        $('#laporan').click(function(e) {
            e.preventDefault();

            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: "GET",
                url: "/laporan",
                data: {
                    "_token": token
                },
                success: function(response) {
                    if (response.redirect === "loginpage") {
                        window.location.href = "/loginpage";
                    } else {
                        $("#content").html(response);
                        $('.nav-link').removeClass('active');
                        $('#laporan').addClass('active');
                    }
                }
            });
        });
        $('#dashboard').click(function(e) {
            e.preventDefault();

            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: "GET",
                url: "/dashboard",
                data: {
                    "_token": token
                },
                success: function(response) {
                    if (response.redirect === "loginpage") {
                        window.location.href = "/loginpage";
                    } else {
                        $("#content").html(response);
                        $('.nav-link').removeClass('active');
                        $('#dashboard').addClass('active');
                    }
                }
            });
        });
    </script>
</body>

</html>
