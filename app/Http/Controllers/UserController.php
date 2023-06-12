<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $datas = User::all();
        if ($request->ajax()) {
            return datatables()->of($datas)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return view('admin.user.aksi')->with('datas', $row);
                })
                ->make(true);
        }

        return view('admin.user.user', compact('datas'));
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
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required',
            'password' => 'required',
            'roles' => 'required',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->roles = $request->input('roles');
        $user->save();

        return response()->json(['message' => 'Data Berhasil Disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $d = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required',
            'password' => 'nullable',
            'roles' => 'required',
        ]);
        dd($d);
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->roles = $request->input('roles');
        $user->save();

        return response()->json(['message' => 'Data Berhasil Diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'Data User Berhasil Dihapus');
    }

    public function settings($id)
    {
        $user = User::find($id);

        return view('admin.user.settings', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required',
            'password' => 'nullable',
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect()->back()->with('success', 'data berhasil diubah');
    }
}
