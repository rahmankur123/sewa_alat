<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ================= LIST USER =================
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(12);

        return view('petugas.user.index', compact('users'));
    }

    // ================= FORM TAMBAH =================
    public function create()
    {
        return view('petugas.user.create');
    }

    // ================= SIMPAN =================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'status' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        // ambil field aman
        $data = $request->only(['name','email','alamat','status','no_hp','role']);

        // default role
        $data['role'] = $request->role ?? 'anggota';

        // hash password
        $data['password'] = Hash::make($request->password);

        // upload foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('user', 'public');
        }

        User::create($data);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('petugas.user.edit', compact('user'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'status' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'password' => 'nullable|min:6|confirmed',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name','email','alamat','status','no_hp','role']);

        // password optional
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // upload foto baru
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('user', 'public');
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diupdate');
    }

    // ================= HAPUS =================
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}