@extends('layouts.main')
@section('title', 'Kasir')
@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Kasir</h1>
        </div>
        <div class="card-body">
            <form id="form-transaksi" method="POST">
                @csrf
                <!-- Input tanggal transaksi -->
                {{-- <div class="mb-3">
                    <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi:</label>
                    <input type="date" class="form-control mb-3 flatpickr-no-config" placeholder="Select date.."
                        id="tanggal_transaksi" name="tanggal_transaksi" />
                </div> --}}

                <!-- Input produk dan jumlah -->
                <div class="mb-3">
                    <label for="produk_id" class="form-label">Produk:</label>
                    <select class="form-select" id="produk_id" name="produk_id">
                        <!-- Opsi produk yang dapat dipilih -->
                        <!-- Jika Anda ingin mengambil opsi produk dari database, Anda dapat menggunakan foreach di sini -->
                        @foreach ($produk as $product)
                            <option value="{{ $product->id }}">{{ $product->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah:</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah">
                </div>

                <button type="button" id="tambah-produk" class="btn btn-primary">Tambah Produk</button>

                <hr>

                <!-- Tabel barang yang dibeli -->
                <h3>Barang yang Dibeli</h3>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-produk">
                        <!-- Daftar barang yang dibeli akan ditambahkan secara dinamis di sini -->
                    </tbody>
                </table>

                <div class="d-flex justify-content-end">
                    <div id="total-harga" class="my-5 h2"></div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="btn-bayar">Bayar</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/extensions/flatpickr/flatpickr.min.js"></script>
    <script src="assets/static/js/pages/date-picker.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        flatpickr('.flatpickr-no-config', {
            "locale": "id" // locale for this instance only
        });
    </script>
    <script>
        $(document).ready(function() {
            // Daftar produk dengan harga per barang
            var products = {
                @foreach ($produk as $product)
                    "{{ $product->id }}": {
                        name: '{{ $product->nama }}',
                        price: {{ $product->harga_jual }}
                    },
                @endforeach
            };

            // Tambahkan produk ke dalam tabel saat tombol tambah diklik
            $('#tambah-produk').click(function() {
                var produk_id = $('#produk_id').val();
                var jumlah = $('#jumlah').val();

                if (produk_id && jumlah) {
                    var productName = products[produk_id].name;
                    var price = products[produk_id].price;
                    var total = price * jumlah;

                    var newRow = '<tr>' +
                        '<td data-product-id="' + produk_id + '">' + productName + '</td>' +
                        '<td>' + jumlah + '</td>' +
                        '<td>Rp ' + price + '</td>' +
                        '<td>Rp ' + total + '</td>' +
                        '<td class="d-flex justify-content-center"><button type="button" class="btn btn-danger btn-delete">Hapus</button></td>' +
                        '</tr>';

                    $('#tabel-produk').append(newRow);

                    $('#produk_id').val('');
                    $('#jumlah').val('');

                    updateTotalHarga();
                }
            });

            // Hapus produk dari tabel saat tombol hapus diklik
            $(document).on('click', '.btn-delete', function() {
                $(this).closest('tr').remove();
                updateTotalHarga();
            });

            // Hitung total harga
            function updateTotalHarga() {
                var total = 0;

                $('#tabel-produk tr').each(function() {
                    var jumlah = parseInt($(this).find('td:nth-child(2)').text(), 10);
                    var price = parseInt($(this).find('td:nth-child(3)').text().replace('Rp ', ''), 10);
                    var subtotal = jumlah * price;

                    total += subtotal;

                    $(this).find('td:nth-child(4)').text('Rp ' + subtotal);
                });


                $('#total-harga').text('Total Harga: Rp ' + total);
            }

            var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            $('#btn-bayar').click(function(e) {
                // Mendapatkan data dari tabel
                e.preventDefault();
                var tableData = getTableData();

                // Mengirim data ke server menggunakan AJAX
                $.ajax({
                    url: '{{ route('kasir.store') }}',
                    method: 'POST',
                    data: {
                        tableData: tableData
                    },
                    success: function(response) {
                        // Tindakan yang dilakukan setelah berhasil mengirim data ke server
                        console.log(response);
                        // Reset atau hapus data di tabel
                        $('#tabel-produk').empty();
                        // Reset total harga
                        $('#total-harga').text('Total Harga: Rp 0');
                    },
                    error: function(xhr, status, error) {
                        // Tindakan yang dilakukan jika terjadi kesalahan saat mengirim data
                        console.error(error);
                    }
                });
            });

            function getTableData() {
                var tableData = [];

                $('#tabel-produk tr').each(function() {
                    var produk_id = $(this).find('td:nth-child(1)').data('product-id');
                    var jumlah = parseInt($(this).find('td:nth-child(2)').text().trim());
                    var harga = parseInt($(this).find('td:nth-child(3)').text().replace('Rp ', '').replace(
                        ',', ''));

                    var total_harga = jumlah * harga;

                    // Tambahkan data ke dalam array
                    tableData.push({
                        produk_id: produk_id,
                        jumlah: jumlah,
                        total_harga: total_harga
                    });
                });

                return tableData;
            }
        });
    </script>
@endpush
