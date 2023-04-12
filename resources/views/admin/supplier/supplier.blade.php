@extends('layouts.main')
@section('title', 'Supplier')
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
                        <h4 class="page-title text-uppercase ml-2">Data Supplier</h4>
                        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                            data-bs-target="#supplierModal">
                            Tambah Supplier
                        </button>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="supplierModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="row g-3" id="supplier-tambah" method="POST">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="no_telepon" class="form-label">No Telepon</label>
                                        <input type="text" class="form-control" id="no_telepon" name="no_telepon">
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

                <!-- Modal Edit Supplier-->
                <div class="modal fade" id="modalEditSupplier" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="row g-3" id="supplier-edit">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="mmid">
                                    <div class="col-md-12">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="edit_nama" name="nama">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="no_telepon" class="form-label">No Telepon</label>
                                        <input type="text" class="form-control" id="edit_no_telepon" name="no_telepon">
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
                        <table class="table" id="table-supplier">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Name</th>
                                    <th>No Telepon</th>
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
            const table = $('#table-supplier').DataTable({
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: "{{ route('supplier.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false

                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'no_telepon',
                        name: 'no_telepon'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                    },
                ]
            });

            $('#supplier-tambah').on('submit', function(event) {
                event.preventDefault(); // Menghentikan submit form
                $.ajax({
                    url: '{{ route('supplier.store') }}',
                    method: 'POST',
                    data: $(this).serialize(), // Mengambil data dari form
                    dataType: 'json',
                    success: function(response) {
                        $('#supplier-tambah')[0].reset();
                        swal("Success", "Data Is Successfully saved", "success").then(
                            () => {
                                $('#supplierModal').modal('hide'); // Menutup modal
                                $('.is-invalid').removeClass('is-invalid');
                                $('.invalid-feedback').remove();
                                $('#table-supplier').DataTable().ajax
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
                $.ajax({
                    url: "/admin/supplier/" + id,
                    type: 'PUT',
                    data: form.serialize(),
                    success: function(response) {
                        // $('#modal-edit').modal('hide');
                        // location.reload();
                        swal("Success", "Data Is Successfully saved", "success").then(() => {
                            $('#modalEditSupplier').modal('hide');
                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').remove();
                            $('#table-supplier').DataTable().ajax
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
                var name = $(this).closest('tr').find('td:eq(1)').text();
                console.log(name)
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            swal("Success", `Data ${name} is Deleted`, "success").then(() => {
                                form.submit()
                            })
                        } else {
                            swal("Cancelled", "Data is safe :)", "error");
                        }
                    });
            });

            $(document).on('click', '.edit', function() {
                var id = $(this).data('id');
                $('#modalEditSupplier').modal('show');
                $('#supplier-edit').attr('action', '/admin/supplier/' + id);
                $.ajax({
                    url: '/admin/supplier/' + id + '/edit',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {

                        $('#edit_nama').val(response.supplier.nama);
                        $('#edit_kategori').val(response.supplier.kategori);
                        $('#edit_harga_beli').val(response.supplier.harga_beli);
                        $('#edit_harga_jual').val(response.supplier.harga_jual);
                        $('#mmid').val(id)

                        // tambahkan kode untuk mengisi nilai form dengan data yang diambil dari database
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
