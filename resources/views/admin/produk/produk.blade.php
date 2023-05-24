@extends('layouts.main')
@section('title', 'produk')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>DataTable jQuery</h3>
                    <p class="text-subtitle text-muted">
                        Powerful interactive tables with datatables (jQuery required).
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                DataTable jQuery
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="page-title text-uppercase ml-2">Data Produk</h4>
                        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                            data-bs-target="#modal-tambah">
                            Tambah Produk
                        </button>
                    </div>
                </div>
                <!-- Modal Tambah Produk-->
                <div class="modal fade" id="modal-tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="row g-3" id="form-tambah">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" id="kategori" name="kategori">
                                    </div>
                                    <div class="col-6">
                                        <label for="harga_beli" class="form-label">Harga Beli</label>
                                        <input type="number" class="form-control" id="harga_beli" name="harga_beli"
                                            min="0">
                                    </div>
                                    <div class="col-6">
                                        <label for="harga_jual" class="form-label">Harga Jual</label>
                                        <input type="number" class="form-control" id="harga_jual" name="harga_jual"
                                            min="0">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Modal Edit Produk-->
                <div class="modal fade" id="modal-edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="row g-3" id="form-edit">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="mmid">
                                    <div class="col-md-12">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="edit_nama" name="nama">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" id="edit_kategori" name="kategori">
                                    </div>
                                    <div class="col-6">
                                        <label for="harga_beli" class="form-label">Harga Beli</label>
                                        <input type="number" class="form-control" id="edit_harga_beli"
                                            name="harga_beli" min="0">
                                    </div>
                                    <div class="col-6">
                                        <label for="harga_jual" class="form-label">Harga Jual</label>
                                        <input type="number" class="form-control" id="edit_harga_jual"
                                            name="harga_jual" min="0">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table-produk">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>ID Produk</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Basic Tables end -->
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            const table = $('#table-produk').DataTable({
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: "{{ route('produk.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false

                    },
                    {
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'kategori',
                        name: 'kategori'
                    },
                    {
                        data: 'harga_beli',
                        name: 'harga_beli'
                    },
                    {
                        data: 'harga_jual',
                        name: 'harga_jual',
                        orderable: false
                    },
                    {
                        data: 'stok',
                        name: 'stok'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                    },
                ]
            });

            $('#form-tambah').on('submit', function(event) {
                event.preventDefault(); // Menghentikan submit form

                var beli = parseInt($('#harga_beli').val());
                var jual = parseInt($('#harga_jual').val());

                if (jual < beli) {
                    swal("Error", "Harga Jual lebih rendah dari Harga Beli", "error");
                    event.preventDefault();
                    return false;
                }
                $.ajax({
                    url: '{{ route('produk.store') }}',
                    method: 'POST',
                    data: $(this).serialize(), // Mengambil data dari form
                    dataType: 'json',
                    success: function(response) {
                        $('#form-tambah')[0].reset();

                        var successMessage = response.message;
                        swal("Success", successMessage, "success").then(
                            () => {
                                $('#modal-tambah').modal('hide'); // Menutup modal
                                $('.is-invalid').removeClass('is-invalid');
                                $('.invalid-feedback').remove();
                                $('#table-produk').DataTable().ajax
                                    .reload(); // Mengambil data baru pada DataTables
                            })

                    },
                    error: function(xhr) {
                        // console.log(xhr.responseText);
                        var errors = xhr.responseJSON
                            .errors; // Mendapatkan pesan kesalahan dari respons Ajax

                        // Menampilkan pesan kesalahan pada form
                        $.each(errors, function(key, value) {
                            var errorHtml = '<div class="invalid-feedback">' +
                                value +
                                '</div>';
                            $('#' + key).addClass('is-invalid').after(errorHtml);
                        });
                    }
                });


            });

            $(document).on('submit', '#form-edit', function(event) {
                event.preventDefault();
                var form = $(this);
                var id = $('#mmid').val();

                var beli = parseInt($('#edit_harga_beli').val());
                var jual = parseInt($('#edit_harga_jual').val());

                if (jual < beli) {
                    swal("Error", "Harga Jual lebih rendah dari Harga Beli", "error");
                    event.preventDefault();
                    return false;
                }
                $.ajax({
                    url: "/admin/produk/" + id,
                    type: 'PUT',
                    data: form.serialize(),
                    success: function(response) {
                        // $('#modal-edit').modal('hide');
                        // location.reload();
                        var successMessage = response.message;
                        swal("Success", successMessage, "success").then(() => {
                            $('#modal-edit').modal('hide');
                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').remove();
                            $('#table-produk').DataTable().ajax
                                .reload();
                        })

                    },
                    error: function(xhr) {
                        // console.log(xhr.responseText);

                        var errors = xhr.responseJSON
                            .errors; // Mendapatkan pesan kesalahan dari respons Ajax

                        // Menampilkan pesan kesalahan pada form
                        $.each(errors, function(key, value) {
                            var errorHtml = '<div class="invalid-feedback">' + value +
                                '</div>';
                            $('#edit_' + key).addClass('is-invalid').after(errorHtml);

                        });
                    }
                });
            });

            var successMessage = $('#success-message');

            // Jika pesan success tampil, sembunyikan setelah 3 detik
            if (successMessage.length > 0) {
                setTimeout(function() {
                    successMessage.hide();
                }, 3000); // 3000 milidetik = 3 detik
            }

            $(document).on('click', '.delete-confirm', function(event) {
                event.preventDefault();
                var form = $(this).closest('form');
                var id = $(this).data('id');
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            swal("Success", `Data ${id} is Deleted`, "success").then(() => {
                                form.submit()
                            })
                        } else {
                            swal("Cancelled", "Data is safe :)", "error");
                        }
                    });
            });

        });
    </script>

    <script>
        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            $('#modal-edit').modal('show');
            $('#form-edit').attr('action', '/admin/produk/' + id);
            $.ajax({
                url: '/admin/produk/' + id + '/edit',
                type: 'GET',
                dataType: 'json',
                success: function(response) {

                    $('#edit_nama').val(response.produk.nama);
                    $('#edit_kategori').val(response.produk.kategori);
                    $('#edit_harga_beli').val(response.produk.harga_beli);
                    $('#edit_harga_jual').val(response.produk.harga_jual);
                    $('#mmid').val(id)

                    // tambahkan kode untuk mengisi nilai form dengan data yang diambil dari database
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endpush
