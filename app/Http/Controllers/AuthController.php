<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Exibe a página de Index no caso Login
    public function index()
    {
        return view('auth.login');
    }

    // Exibe a página de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Exibe a página de registro
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Processa o logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
