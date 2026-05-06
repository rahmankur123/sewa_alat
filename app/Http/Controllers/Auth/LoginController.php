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
            return view('dashboard.admin');
        }

        if($role == 'petugas'){
            return view('dashboard.index');
        }

        if($role == 'anggota'){
            return view('dashboard.anggota');
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