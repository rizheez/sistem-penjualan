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
        $produk = Produk::all();
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
            'harga_beli' => 'required',
            'jumlah' => 'required',
        ]);

        $jumlah = $request->jumlah;

        $produkMasuk = new ProdukMasuk();
        $produkMasuk->produk_id = $request->produk_id;
        $produkMasuk->supplier_id = $request->supplier_id;
        $produkMasuk->tangal_masuk = $request->tangal_masuk;
        $produkMasuk->jumlah = $jumlah;


        $produk = Produk::find($produkMasuk->produk_id);
        $produk->harga_beli = $request->harga_beli;
        $produk->stok += $produkMasuk->jumlah;
        $produk->save();
        $produkMasuk->save();

        return response()->json(['message' => 'Data Berhasil Disimpan']);
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
    public function edit($id)
    {
        $produkMasuk = ProdukMasuk::find($id);
        $produk = $produkMasuk->produk;
        $supplier = Supplier::all(['id', 'nama']);

        return response()->json([
            'produkMasuk' => $produkMasuk,
            'produk' => $produk,
            'supplier' => $supplier
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $produkMasuk = ProdukMasuk::find($id);
        $request->validate([
            'produk_id' => 'required',
            'supplier_id' => 'required',
            'tangal_masuk' => 'required',
            'harga_beli' => 'required',

        ]);

        $produkMasuk->produk_id = $request->produk_id;
        $produkMasuk->supplier_id = $request->supplier_id;
        $produkMasuk->tangal_masuk = $request->tangal_masuk;


        $produk = Produk::find($produkMasuk->produk_id);
        $produk->harga_beli = $request->harga_beli;
        $produk->save();
        $produkMasuk->save();

        return response()->json(['message' => 'Data Berhasil Diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produkMasuk = ProdukMasuk::find($id);

        // Mengurangi stok produk terkait
        $produk = $produkMasuk->produk;
        $produk->stok -= $produkMasuk->jumlah;
        $produk->save();

        $produkMasuk->delete();

        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }
}
