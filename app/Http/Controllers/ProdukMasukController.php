<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukMasuk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProdukMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ProdukMasuk::with(['produk', 'supplier'])->get();
        $produk = Produk::all(['id', 'nama']);
        $supplier = Supplier::all(['id', 'nama']);
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return view('admin.produk_masuk.aksi')->with('data', $row);
                })
                ->make(true);
        }

        return view('admin.produk_masuk.produk_masuk')->with(['data' => $data, 'produk' => $produk, 'supplier' => $supplier]);
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
        $request->validate([
            'produk_id' => 'required',
            'supplier_id' => 'required',
            'tangal_masuk' => 'required',
            'jumlah' => 'required',
        ]);

        $jumlah = $request->jumlah;

        $produkMasuk = new ProdukMasuk();
        $produkMasuk->produk_id = $request->produk_id;
        $produkMasuk->supplier_id = $request->supplier_id;
        $produkMasuk->tangal_masuk = $request->tangal_masuk;
        $produkMasuk->jumlah = $jumlah;


        $produk = Produk::find($produkMasuk->produk_id);
        $produk->stok += $produkMasuk->jumlah;
        $produk->save();
        $produkMasuk->save();

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProdukMasuk $produkMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProdukMasuk $produkMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProdukMasuk $produkMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = ProdukMasuk::find($id);

        $produk->delete();

        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }
}
