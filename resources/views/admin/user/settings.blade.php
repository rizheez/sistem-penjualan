@extends('layouts.main')
@section('title', 'User Settings')
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

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="page-title text-uppercase ml-2">Edit Data</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form class="row g-3" id="form-edit" action="{{ route('user.updated', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="mmid">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_name" name="name"
                                value="{{ $user->name }}">
                        </div>
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email"
                                value="{{ $user->email }}">
                        </div>

                        <div class="col-md-12">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="edit_username" name="username"
                                value="{{ $user->username }}">
                        </div>
                        <div class="col-md-12">
                            <label for="password" class="form-label">Password</label>

                            <input type="password" class="form-control" id="edit_password" name="password"
                                placeholder="********">
                            <small class="fw-bold fst-italic text-uppercase">(Jangan diisi jika tidak ingin mengubah
                                password)</small>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary mx-3">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        document.querySelector('#form-edit').addEventListener('submit', (e) => {
            e.preventDefault();
            swal({
                icon: 'success',
                title: 'Success',
                text: 'Data berhasil disimpan',
                button: {
                    className: 'btn btn-success',
                }
            }).then((result) => {
                if (result == true) {
                    e.target.submit();
                }
            })
        });
    </script>
@endpush
