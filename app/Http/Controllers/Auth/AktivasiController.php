<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AktivasiController extends Controller
{
    public function form($token)
    {
        $user = User::where('token_aktivasi', $token)->firstOrFail();

        return view('auth.aktivasi', compact('user'));
    }

    public function proses(Request $request, $token)
    {
        $user = User::where('token_aktivasi', $token)->firstOrFail();

        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $user->update([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'status' => 'aktif',
            'token_aktivasi' => null
        ]);

        return redirect('/login')->with('success','Akun berhasil diaktivasi');
    }
}