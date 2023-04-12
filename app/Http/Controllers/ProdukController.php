<?php

namespace App\Http\Controllers;


use App\Models\Produk;
use Illuminate\Http\Request;


class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Produk::all();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return view('admin.produk.aksi')->with('data', $row);
                })
                ->make(true);
        }
        return view('admin.produk.produk', compact('data'));
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
            'nama' => 'required|string|max:100',
            'kategori' => 'required|string|max:255',
            'harga_beli' => 'required',
            'harga_jual' => 'required',

        ]);

        $produk = new Produk();
        $produk->nama = $request->nama;
        $produk->kategori = $request->kategori;
        $produk->harga_beli = $request->harga_beli;
        $produk->harga_jual = $request->harga_jual;
        $produk->stok = 0;
        $produk->save();

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produk = Produk::find($id);

        return response()->json([
            'produk' => $produk
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $id = $request->input('id');
        $produk = Produk::find($id);
        $request->validate([
            'nama' => 'required|string|max:100',
            'kategori' => 'required|string|max:255',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
        ]);

        $produk->nama = $request->nama;
        $produk->kategori = $request->kategori;
        $produk->harga_beli = $request->harga_beli;
        $produk->harga_jual = $request->harga_jual;
        $produk->stok = 0;
        $produk->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);

        $produk->delete();

        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }
}
