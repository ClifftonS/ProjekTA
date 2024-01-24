<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>POS Berkat Mulia</title>

    {{-- SweetAlert --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    {{-- Vue --}}
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    {{-- Axios --}}
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
</head>

<body>
    <div class="container-fluid g-0">
        <div class="row g-0">
            @include('sidebar')
            <div class="col-10 g-0">
                <div class="col-10 my-3 offset-1">
                    <div class="row justify-content-start mb-3">
                        <div class="col-auto mt-1">Cari Konsumen</div>
                        <div class="col-5 me-auto">
                            <input type="text" class="input form-control" id="input"
                                placeholder="Cari disini ....">
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-primary mb-3" role="button" data-bs-toggle="modal"
                                data-bs-target="#Tambahkonsumen" data-bs-placement="top"
                                style="display: flex">Tambah</a>
                        </div>
                    </div>
                    <div class="" style="height:320px">
                        <table class="table table-hover table-bordered text-center table-striped align-middle">
                            <thead class="table-dark align-middle">
                                <tr>
                                    <th class="col-2" scope="col">Judul</th>
                                    <th class="col-2" scope="col">Nama Peminjam</th>
                                    <th class="col-2" scope="col">Tanggal Peminjaman</th>
                                    <th class="col-2" scope="col">Tanggal Harus Kembali</th>
                                    <th class="col-2" scope="col">Status</th>
                                    <th class="col-2" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="overflow-scroll" style="max-height: 100px">
                                @foreach ($datasend as $datatable)
                                    <tr>
                                        <td>{{ $datatable->judul }}</td>
                                        <td>{{ $datatable->nama }}</td>
                                        <td>{{ date('d-m-Y', strtotime($datatable->tgl_pmnj)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($datatable->tgl_kembali)) }}</td>
                                        <td>{{ $datatable->status_pmnj == 0 ? 'Masih Dipinjam' : 'Telah Dikembalikan' }}
                                        </td>
                                        <td>
                                            {{-- <a data-bs-toggle="modal" data-bs-target="#Editpeminjaman"
                                                data-id='{"idpmnj":"{{ $datatable->id_pmnj }}","tglpmnj":"{{ $datatable->tgl_pmnj }}","status":"{{ $datatable->status_pmnj }}","idbuku":"{{ $datatable->id_buku }}","idagt":"{{ $datatable->id_agt }}"}'
                                                class="edit text-decoration-none"><i class="icon fa-solid fa-pen-to-square"></i></a> --}}
                                            @if ($datatable->status_pmnj == 0)
                                                <form action="/editpeminjaman" method="post">
                                                    @csrf
                                                    <input type="hidden" name="idpmnj" id="idpmnj"
                                                        value="{{ $datatable->id_pmnj }}" class="form-control-plaintext"
                                                        style="border-radius: 10px;">
                                                    <input type="hidden" name="buku" id="buku"
                                                        value="{{ $datatable->id_buku }}" class="form-control-plaintext"
                                                        style="border-radius: 10px;">
                                                    <input type="submit" class="btn shadow rounded"
                                                        style="background-color: #364F6B; color: white; width: 125px"
                                                        value="Dikembalikan">
                                                </form>
                                            @else
                                                <a data-bs-toggle="modal" data-bs-target="#Deletepeminjaman"
                                                    data-id='{"idpmnj":"{{ $datatable->id_pmnj }}"}'
                                                    class="delete text-decoration-none"><i
                                                        class="icon fa-solid fa-trash-can"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var app = new Vue({
            el: '#app',
            mounted() {
                this.getDataList();
            },
            data: {
                data_list: [],
                content: ""
            },
            methods: {
                getDataList: function() {
                    axios.get("{{ url('') }}")
                        .then(resp => {
                            this.data_list = resp.data;
                        })
                        .catch(err => {
                            alert("Terjadi kesalahan!");
                        })
                }
                saveList: function() {
                    var form_data = new FormData();
                    form_data.append("data", this.content);
                    axios.post("{{ url('') }}", form_data)
                        .then(resp => {
                            var item = resp.data;
                            alert(item.message);
                            this.getDataList();
                        })
                        .catch(err => {
                            alert("Terjaadi kesalahan!")
                        })
                }
            }
        })
    </script>
</body>

</html>
