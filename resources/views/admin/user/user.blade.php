@extends('layouts.main')
@section('title', 'User')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.index') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Data User
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
                        <h4 class="page-title text-uppercase ml-2">Data User</h4>
                        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                            data-bs-target="#modal-tambah">
                            Tambah User
                        </button>
                    </div>
                </div>
                <!-- Modal Tambah User-->
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
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="name">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" name="email">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="roles" class="form-label">Roles</label>
                                        <select class="form-select" name="roles" id="roles">
                                            <option selected disabled>-- Pilih Roles --</option>
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
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

                <!-- Modal Edit User-->
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
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="edit_name" name="name">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="edit_email" name="email">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="edit_username" name="username">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="edit_password" name="password"
                                            placeholder="********">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="roles" class="form-label">Roles</label>
                                        <select class="form-select" name="roles" id="edit_roles">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
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
                        <table class="table" id="table-user">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Roles</th>
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
            const table = $('#table-user').DataTable({
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: "{{ route('user.index') }}",
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                        orderable: false
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


                $.ajax({
                    url: '{{ route('user.store') }}',
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
                                $('#table-user').DataTable().ajax
                                    .reload(); // Mengambil data baru pada DataTables
                            })

                    },
                    error: function(xhr) {
                        // console.log(xhr.responseText);
                        var errors = xhr.responseJSON
                            .errors; // Mendapatkan pesan kesalahan dari respons Ajax
                        console.log(xhr.responseJSON)
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
                    url: "/admin/user/" + id,
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
                            $('#table-user').DataTable().ajax
                                .reload();
                        })

                    },
                    error: function(xhr) {
                        // console.log(xhr.responseText);

                        var errors = xhr.responseJSON
                            .errors; // Mendapatkan pesan kesalahan dari respons Ajax
                        console.log(xhr.responseJSON.message)
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
                            swal("Success", `Data ${id} is Deleted`, "success", {
                                button: {
                                    className: "btn btn-success",
                                }
                            }).then(() => {
                                form.submit()
                            })
                        } else {
                            swal("Cancelled", "Data is safe :)", "info", {
                                button: {
                                    className: "btn btn-primary",
                                }
                            });
                        }
                    });
            });

        });
    </script>

    <script>
        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            $('#modal-edit').modal('show');
            $('#form-edit').attr('action', '/admin/user/' + id);
            $.ajax({
                url: '/admin/user/' + id + '/edit',
                type: 'GET',
                dataType: 'json',
                success: function(response) {

                    $('#edit_name').val(response.user.name);
                    $('#edit_email').val(response.user.email);
                    $('#edit_username').val(response.user.username);

                    $('#edit_roles').val(response.user.roles);
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
