@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <div class="page-heading">
        <h3>Statistics <i class="fas fa-chart-line"></i></h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5 mb-2">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">
                                            Produk
                                        </h6>
                                        <h6 class="font-extrabold mb-0">{{ $produkCount }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5 mb-lg-2">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Supplier</h6>
                                        <h6 class="font-extrabold mb-0">{{ $supplierCount }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Pendapatan Bulan
                                            {{ Illuminate\Support\Carbon::now()->translatedFormat('F Y') }}</h6>
                                        <h6 class="font-extrabold mb-0">RP {{ $pendapatanBulan }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Pendapatan Hari Ini</h6>
                                        <h6 class="font-extrabold mb-0">RP {{ $pendapatanHari }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pendapatan Bulanan <i class="fas fa-chart-bar"></i></h4>
                            </div>
                            <div class="card-body">
                                <div id="chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                <img src="./assets/compiled/jpg/1.jpg" alt="Face 1" />
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                                <h6 class="text-muted mb-0">{{ Auth::user()->roles }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>5 Produk Paling Laris <i class="fas fa-chart-pie"></i></h4>
                    </div>
                    <div class="card-body">
                        <canvas id="chart-top-product"></canvas>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
@push('script')
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ asset('assets/extensions/chart.js/chart.umd.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Chart initialization code here
            var optionsPendapatan = {
                annotations: {
                    position: "back",
                },
                dataLabels: {
                    enabled: false,
                },
                chart: {
                    type: "bar",
                    height: 300,
                },
                fill: {
                    opacity: 1,
                },
                plotOptions: {},
                series: [{
                    name: "Pendapatan",
                    data: {!! json_encode(array_column($chartData, 'pendapatan')) !!},
                }, ],
                colors: "#435ebe",
                xaxis: {
                    categories: {!! json_encode(array_column($chartData, 'bulan')) !!},
                },
            }


            const topProduct = {!! json_encode($topProducts) !!};

            // Mendapatkan data dan label dari $topProducts
            const data = topProduct.map(product => product.total_pembelian);
            const labels = topProduct.map(product => product.nama);

            // Membuat chart menggunakan Chart.js
            const ctx = document.getElementById('chart-top-product').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: topProduct.map(product => product.nama),
                    datasets: [{
                        data: topProduct.map(product => product.total_pembelian),
                        backgroundColor: ['#435ebe', '#55c6e8', '#ffbb00', '#ff5555', '#00cc99'],
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                    },
                    tooltips: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw.toLocaleString();
                            },
                        },
                    },
                },
            })



            var chart = new ApexCharts(
                document.querySelector("#chart"),
                optionsPendapatan
            )


            chart.render();

        });
    </script>
@endpush
