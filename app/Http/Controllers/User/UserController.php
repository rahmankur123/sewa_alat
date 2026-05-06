<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function editProfil()
    {
        $user = auth()->user();
        return view('anggota.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'password' => 'nullable|confirmed|min:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only('name','email','no_hp','alamat');

        // HANDLE PASSWORD
    if($request->filled('password')){
        $data['password'] = Hash::make($request->password);
    } else {
        unset($data['password']);
    }

     // HANDLE FOTO
    if($request->hasFile('foto')){
        if($user->foto){
            Storage::disk('public')->delete($user->foto);
        }

        $data['foto'] = $request->file('foto')->store('users','public');
    }

    $user->update($data);

    return back()->with('success','Profil berhasil diperbarui');
    }
}