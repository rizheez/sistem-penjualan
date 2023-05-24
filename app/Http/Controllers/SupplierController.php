<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Supplier::all();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return view('admin.supplier.aksi')->with('data', $row);
                })
                ->make(true);
        }
        return view('admin.supplier.supplier', compact('data'));
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
            'no_telepon' => 'required|string|max:13',
        ]);

        $supplier = new Supplier();
        $supplier->nama = $request->nama;
        $supplier->no_telepon = $request->no_telepon;
        $supplier->save();

        return response()->json(['message' => 'Data Berhasil Disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);

        return response()->json([
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:255',
        ]);

        $supplier = Supplier::find($id);
        $supplier->nama = $request->nama;
        $supplier->no_telepon = $request->no_telepon;
        $supplier->save();

        return response()->json(['message' => 'Data Berhasil Diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);

        $supplier->delete();

        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }
}
