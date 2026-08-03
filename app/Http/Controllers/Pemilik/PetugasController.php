<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Transaksi;
use DB;

class PetugasController extends Controller
{
    // ================= LIST USER =================
    public function index(Request $request)
    {
        $query = User::where(function($q) {
            $q->where('role', 'petugas')
              ->orWhere('role', 'pemilik');
        });

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $users = $query->latest()->paginate(12);

        return view('pemilik.user.index', compact('users'));
    }

    // ================= FORM TAMBAH =================
    public function create()
    {
        return view('pemilik.user.create');
    }

    // ================= SIMPAN =================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'no_hp' => 'required',
            'alamat' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        // ambil field aman
        $data = $request->only(['name','email','alamat','no_hp','role']);

        // default role
        $data['role'] = $request->role ?? 'petugas';

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
        return view('pemilik.user.edit', compact('user'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'required',
            'alamat' => 'required',
            'password' => 'nullable|min:6|confirmed',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name','email','alamat','no_hp','role']);

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

        return redirect()->route('pemilik.user.index')->with('success', 'User berhasil diupdate');
    }

    // ================= HAPUS =================
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        DB::beginTransaction();

        try {
            // Ambil semua transaksi user
            $transaksiList = Transaksi::where('user_id', $user->id)->get();

            foreach ($transaksiList as $transaksi) {

                // Hapus relasi terlebih dahulu
                $transaksi->detail()->delete();
                $transaksi->kerusakan()->delete();
                $transaksi->keterlambatan()->delete();
                $transaksi->barangHilang()->delete();

                // Hapus transaksi
                $transaksi->delete();
            }

            // Hapus user
            $user->delete();

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'User berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}