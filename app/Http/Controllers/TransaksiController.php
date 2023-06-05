<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $data = TransaksiDetail::with(['transaksi', 'produk', 'users'])->get();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                // ->addColumn('aksi', function ($row) {
                //     return view('admin.produk_masuk.aksi')->with('data', $row);
                // })
                ->make(true);
        }
        return view('admin.transaksi_detail', compact('data'));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaksi $transaksi)
    {
        //
    }
}
