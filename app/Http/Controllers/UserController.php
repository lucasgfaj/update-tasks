<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    // Processa o registro
    public function register(Request $request)
    {
        // Valida os dados
        $request->validate([
            'name' => 'required|string|max:400',
            'email' => 'required|string|email|max:400|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'O e-mail informado já está em uso.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        // Prepara os dados para inserção
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Criptografa a senha
            'role' => 'user',
            'level' => 1,
            'created_at' => Carbon::now(),
        ];

        // Chama o método de criação no modelo User
        User::create($data);

        return redirect()->route('login')->with('success', 'Registro realizado com sucesso!');
    }
    // Processa o login
    public function login(Request $request)
    {
        // Valida as credenciais
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Verifica se o usuário existe com o email fornecido
        $user = User::getUserByEmail($request->email); // Usando o método no modelo

        // Verifica se o usuário foi encontrado e se a senha corresponde
        if ($user && Hash::check($request->password, $user[0]->password)) {
            Auth::loginUsingId($user[0]->id_user);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'O email ou a senha fornecidos não são válidos.',
        ]);
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
