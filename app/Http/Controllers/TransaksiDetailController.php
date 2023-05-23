<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TransaksiDetail;

class TransaksiDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = TransaksiDetail::with('transaksi')->get();
        $produk = Produk::all(['id', 'nama', 'harga_jual']);
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                // ->addColumn('aksi', function ($row) {
                //     return view('admin.produk_masuk.aksi')->with('data', $row);
                // })
                ->make(true);
        }
        return view('admin.kasir.kasir', compact('data', 'produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validasi inputan jika diperlukan
        $request->validate([
            'tableData' => 'required|array',
            'tableData.*.produk_id' => 'required|exists:produk,id',
            'tableData.*.jumlah' => 'required|numeric',
            'tableData.*.total_harga' => 'required|numeric|min:0',
        ]);

        // Simpan data transaksi ke dalam tabel transaksi
        $transaksi = new Transaksi();
        $transaksi->tanggal_transaksi = Carbon::now();
        $transaksi->save();

        // Simpan data transaksi_detail ke dalam tabel transaksi_detail
        $items = $request->input('tableData');
        foreach ($items as $item) {
            $transaksiDetail = new TransaksiDetail();
            $transaksiDetail->transaksi_id = $transaksi->id;
            $transaksiDetail->produk_id = $item['produk_id'];
            $transaksiDetail->jumlah = $item['jumlah'];
            // Jika harga produk disimpan di tabel transaksi_detail, Anda juga perlu mengambil harganya dari database
            // dan mengatur nilai price di sini.
            $transaksiDetail->total_harga = $item['total_harga'];
            $transaksiDetail->save();

            // Mengurangi stok produk terkait
            $produk = Produk::find($item['produk_id']);
            $produk->stok -= $item['jumlah'];
            $produk->save();
        }

        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiDetail $transaksiDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiDetail $transaksiDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiDetail $transaksiDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiDetail $transaksiDetail)
    {
        //
    }
}
