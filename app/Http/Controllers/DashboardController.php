<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        setlocale(LC_TIME, 'id_ID.utf8');

        $produkCount = Produk::count();
        $supplierCount = Supplier::count();

        $hariSekarang = Carbon::now()->setTimezone('Asia/Makassar');


        $pendapatanHari = Transaksi::join('transaksi_detail', 'transaksi.id', '=', 'transaksi_detail.transaksi_id')
            ->whereDay('transaksi.tanggal_transaksi', $hariSekarang)
            ->sum('transaksi_detail.total_harga');

        $pendapatanBulan = Transaksi::join('transaksi_detail', 'transaksi.id', '=', 'transaksi_detail.transaksi_id')
            ->whereMonth('transaksi.tanggal_transaksi', Carbon::now()->month)
            ->sum('transaksi_detail.total_harga');

        $revenueData = DB::table('transaksi')
            ->leftJoin('transaksi_detail', 'transaksi.id', '=', 'transaksi_detail.transaksi_id')
            ->select(DB::raw('MONTH(transaksi.tanggal_transaksi) AS bulan'), DB::raw('COALESCE(SUM(transaksi_detail.total_harga), 0) AS pendapatan'))
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->get();

        $chartData = $this->generateChartData($revenueData);

        $topProducts = TransaksiDetail::join('produk', 'transaksi_detail.produk_id', '=', 'produk.id')
            ->join('transaksi', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
            ->select('produk.nama', DB::raw('SUM(jumlah) as total_pembelian'))
            ->groupBy('transaksi_detail.produk_id', 'produk.nama')
            ->orderByDesc('total_pembelian')
            ->limit(5)
            ->get();



        return view('admin.dashboard', compact('produkCount', 'supplierCount', 'pendapatanBulan', 'pendapatanHari', 'chartData', 'topProducts'));
    }

    private function generateChartData($revenueData)
    {
        $allMonths = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $chartData = [];

        foreach ($allMonths as $month) {
            $found = false;

            foreach ($revenueData as $data) {
                $carbonMonth = Carbon::create()->month($data->bulan)->locale('id');
                $bulan = $carbonMonth->translatedFormat('F');

                if ($bulan === $month) {
                    $found = true;
                    $pendapatan = $data->pendapatan;
                    $chartData[] = ['bulan' => $bulan, 'pendapatan' => $pendapatan];
                    break;
                }
            }

            if (!$found) {
                $chartData[] = ['bulan' => $month, 'pendapatan' => 0];
            }
        }

        return $chartData;
    }
}
