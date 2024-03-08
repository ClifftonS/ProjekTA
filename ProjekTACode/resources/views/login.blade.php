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
</head>

<body>
    <div class="container-fluid g-0">
        <div class="row g-0 vh-100 align-items-center">
            <div class="col-6 g-0 vh-100 bg-dark align-items-center">
                <div class="row align-items-center">
                    <h1 class="text-white display-1 font-weight-bold d-flex justify-content-center">Berkat</h1>
                </div>
                <div class="row d-flex justify-content-center align-items-center">
                    <h1 class="text-white display-1 font-weight-bold d-flex justify-content-center">Mulia</h1>
                </div>
            </div>
            <div class="col-6 px-4 justify-content-center g-0">
                <div class="row">
                    <h2 class="text-dark d-flex justify-content-center">Masuk</h2>
                </div>
                <form method="post" action="/login">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="margin-top: 20px">
                            {!! implode('', $errors->all()) !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row g-1 d-flex justify-content-center mt-2">
                        <div class="col-7">
                            <label for="user" class="col-form-label">Username</label>
                            <input type="text" name="user" id="user" maxlength = "20" class="form-control"
                                style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Nama"
                                required>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center mt-2">
                        <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-user"></div>
                    </div>

                    <div class="row g-1 d-flex justify-content-center">
                        <div class="col-7">
                            <label for="password" class="col-form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control"
                                style="background-color: #F4F9FF; border-radius: 10px;" placeholder="Masukkan Password"
                                required>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center mt-2">
                        <div class="alert alert-danger col-10 d-none p-2" role="alert" id="alert-password"></div>
                    </div>

                    <div class="row d-flex justify-content-center mt-4">
                        <button type="submit" class="btn shadow btn-block"
                            style="background-color: #364F6B; color: white; width: 125px">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
