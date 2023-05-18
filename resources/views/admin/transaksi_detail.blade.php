@extends('layouts.main')
@section('title', 'Transaksi')
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
                {{-- <div class="modal fade" id="supplierModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                </div> --}}

                <!-- Modal Edit Supplier-->
                {{-- <div class="modal fade" id="modalEditSupplier" data-bs-backdrop="static" data-bs-keyboard="false"
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
                </div> --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table-transaksi">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>ID Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
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
            const table = $('#table-transaksi').DataTable({
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                ajax: "{{ route('transaksi.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false

                    },
                    {
                        data: 'transaksi_id',
                        name: 'transaksi_id'
                    },
                    {
                        data: 'transaksi.tanggal_transaksi',
                        name: 'transaksi.tanggal_transaksi'
                    },
                    {
                        data: 'produk.nama',
                        name: 'produk.nama'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'total_harga',
                        name: 'total_harga'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                    },
                ]
            });
        });
    </script>
@endpush
