<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

public function form()
{
    return view('auth.login');
}


public function proses(Request $request)
{

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if(Auth::attempt($credentials))
    {

        $request->session()->regenerate();

        $role = Auth::user()->role;

        if($role == 'pemilik'){
            return redirect()->route('pemilik.dashboard');
        }

        if($role == 'petugas'){
            return redirect()->route('petugas.dashboard');
        }

        if($role == 'anggota'){
            return redirect()->route('anggota.dashboard');
        }

    }

    return back()->with('error','Email atau password salah');
}


public function logout()
{
    Auth::logout();
    return redirect('/');
}

}