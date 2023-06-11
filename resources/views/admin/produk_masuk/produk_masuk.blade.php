@extends('layouts.main')

@section('title', 'Produk Masuk')

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
                                Data Produk Masuk
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
                        <h4 class="page-title text-uppercase ml-2">Data Produk Masuk</h4>
                        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                            data-bs-target="#produkMasukModal">
                            Tambah Produk
                        </button>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="produkMasukModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="row g-3" id="produkMasuk-tambah">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="produk_id" class="form-label">Nama Produk</label>
                                        <div class="dropdown">
                                            <select class="selectpicker" aria-label="Default select example"
                                                data-live-search="true" data-width="100%" name="produk_id" id="produk_id"
                                                title="Pilih Produk" data-size="3">
                                                {{-- <option disabled selected>Open this select menu</option> --}}
                                                @foreach ($produk as $p)
                                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="supplier_id" class="form-label">Nama Supplier</label>
                                        <div class="dropdown">
                                            <select class="selectpicker" aria-label="Default select example"
                                                data-live-search="true" data-width="100%" name="supplier_id"
                                                id="supplier_id" title="Pilih Supplier" data-size="3">
                                                {{-- <option disabled selected>Open this select menu</option> --}}
                                                @foreach ($supplier as $s)
                                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="tangal_masuk" class="form-label">Tanggal Masuk</label>
                                        {{-- <input type="date" class="form-control" id="tangal_masuk" name="tangal_masuk"> --}}
                                        <input type="date" class="form-control mb-3 flatpickr-no-config"
                                            placeholder="Select date.." id="tangal_masuk" name="tangal_masuk" />
                                    </div>
                                    <div class="col-6">
                                        <label for="harga_beli" class="form-label">Harga Beli</label>
                                        <input type="number" class="form-control" id="harga_beli" name="harga_beli"
                                            min="0">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control" id="jumlah" name="jumlah"
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
                                        <label for="produk_id" class="form-label">Nama Produk</label>
                                        <div class="dropdown">
                                            <select class="selectpicker" aria-label="Default select example"
                                                data-live-search="true" data-width="100%" name="produk_id"
                                                id="produk_id" title="Pilih Produk" data-size="3">
                                                {{-- <option disabled selected>Open this select menu</option> --}}
                                                @foreach ($produk as $p)
                                                    <option value="{{ $p->id }}"
                                                        {{ $p->id === $data->pluck('produk_id')->first() ? 'selected' : '' }}>
                                                        {{ $p->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="supplier_id" class="form-label">Nama Supplier</label>
                                        <div class="dropdown">
                                            <select class="selectpicker" aria-label="Default select example"
                                                data-live-search="true" data-width="100%" name="supplier_id"
                                                id="supplier_id" title="Pilih Supplier" data-size="3">
                                                {{-- <option disabled selected>Open this select menu</option> --}}
                                                @foreach ($supplier as $s)
                                                    <option
                                                        value="{{ $s->id }}"{{ $s->id === $data->pluck('supplier_id')->first() ? 'selected' : '' }}
                                                        {{ $s->id === $data->pluck('supplier_id')->first() ? 'selected' : '' }}>
                                                        {{ $s->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="tangal_masuk" class="form-label">Tanggal Masuk</label>
                                        {{-- <input type="date" class="form-control" id="tangal_masuk" name="tangal_masuk"> --}}
                                        <input type="date" class="form-control flatpickr-no-config"
                                            placeholder="Select date.." id="editTanggalMasuk" name="tangal_masuk" />
                                    </div>
                                    <div class="col-md-12">
                                        <label for="harga_beli" class="form-label">Harga Beli</label>
                                        <input type="number" class="form-control" id="editHargaBeli" name="harga_beli"
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

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table-produk-masuk">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Produk</th>
                                    <th>Supplier</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Basic Tables end -->
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/extensions/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/date-picker.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        flatpickr('.flatpickr-no-config', {
            "locale": "id" // locale for this instance only
        });
    </script>
    <script>
        $(document).ready(function() {
            const table = $('#table-produk-masuk').DataTable({
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: "{{ route('produk-masuk.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false

                    },
                    {
                        data: 'produk.nama',
                        name: 'produk.nama',
                    },
                    {
                        data: 'supplier.nama',
                        name: 'supplier.nama'
                    },
                    {
                        data: 'tangal_masuk',
                        name: 'tangal_masuk',
                        render: function(data) {
                            moment.locale('id');
                            return moment(data).format("LL");
                        }
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                    },
                ]
            });

            $('#produkMasuk-tambah').on('submit', function(event) {
                event.preventDefault(); // Menghentikan submit form
                $.ajax({
                    url: '{{ route('produk-masuk.store') }}',
                    method: 'POST',
                    data: $(this).serialize(), // Mengambil data dari form
                    dataType: 'json',
                    success: function(response) {
                        $('#produkMasuk-tambah')[0].reset();
                        swal("Success", "Data Is Successfully saved", "success").then(
                            () => {
                                $('#produkMasukModal').modal('hide'); // Menutup modal
                                $('.is-invalid').removeClass('is-invalid');
                                $('.invalid-feedback').remove();
                                $('#table-produk-masuk').DataTable().ajax
                                    .reload(); // Mengambil data baru pada DataTables
                            })

                    },
                    error: function(xhr) {
                        // console.log(xhr.responseText);
                        var errors = xhr.responseJSON
                            .errors; // Mendapatkan pesan kesalahan dari respons Ajax
                        console.log(xhr.responseText);
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
                    url: "/admin/produk-masuk/" + id,
                    type: 'PUT',
                    data: form.serialize(),
                    success: function(response) {
                        // $('#modal-edit').modal('hide');
                        // location.reload();
                        swal("Success", "Data Is Successfully saved", "success").then(() => {
                            $('#modal-edit').modal('hide');
                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').remove();
                            $('#table-produk-masuk').DataTable().ajax
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
                $('#modal-edit').modal('show');
                $('#form-edit').attr('action', '/admin/produk-masuk/' + id);
                $.ajax({
                    url: '/admin/produk-masuk/' + id + '/edit',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {


                        $('#editTanggalMasuk').val(response.produkMasuk.tangal_masuk);
                        $('#editHargaBeli').val(response.produk.harga_beli);
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
