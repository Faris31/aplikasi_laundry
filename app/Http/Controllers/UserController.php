<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'User';
        $users = User::with('level')->orderBy('id', 'desc')->get();
        return view('admin.user.index', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Silahkan Isi Data User';
        $levels = Level::get();
        return view('admin.user.create', compact('title', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
    // Validasi data sebelum insert
    $validated = $request->validate([
        'name'      => 'required|string|max:255',
        'id_level'  => 'required|integer|exists:levels,id',
        'email'     => 'required|email|unique:users,email',
        'password'  => 'required|min:6'
    ]);

    // Simpan user dengan password terenkripsi
    User::create([
        'name'      => $validated['name'],
        'id_level'  => $validated['id_level'],
        'email'     => $validated['email'],
        'password'  => Hash::make($validated['password']),
    ]);

    // Tampilkan notifikasi sukses
    Alert::success('Selamat!', 'User berhasil ditambahkan');

    // Redirect lebih rapi menggunakan route name
    return redirect()->route('user.index');
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
        $edit = User::find($id);
        $levels = Level::get();
        $title = "Ubah Data User";
        return view('admin.user.edit', compact('edit','title','levels'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, string $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'id_level' => 'required|integer',
        'password' => 'nullable|min:8' // boleh kosong saat update
    ]);

    $users = User::findOrFail($id);

    $users->name = $request->name;
    $users->email = $request->email;
    $users->id_level = $request->id_level;

    if ($request->filled('password')) {
        $users->password = bcrypt($request->password);
    }

    $users->save();

    Alert::success('Berhasil','Data berhasil diubah!');
    return redirect()->to('user');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        Alert::success('Berhasil', 'Data anda berhasil dihapus');
        return redirect()->to('user');
    }
}
