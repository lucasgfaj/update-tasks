<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        ]);

        // Prepara os dados para inserção
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);  // Criptografa a senha
        $role = 'user'; // Role inicial
        $level = 1;  // Nível inicial
        $created_at = Carbon::now(); // Hora atual

        // Inserção usando SQL direto
        DB::insert('INSERT INTO users (name, email, password, role, level, created_at)
                    VALUES (?, ?, ?, ?, ?, ?)', [
                        $name,
                        $email,
                        $password,
                        $role,
                        $level,
                        $created_at
                    ]);

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
        $user = DB::select('SELECT * FROM users WHERE email = ?', [$request->email]);

        // Verifica se o usuário foi encontrado e se a senha corresponde
        if ($user && Hash::check($request->password, $user[0]->password)) {
            // Faz login utilizando o ID correto (id_user)
            Auth::loginUsingId($user[0]->id_user); // Usa id_user em vez de id
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // Caso o login falhe, retorna uma mensagem de erro
        return back()->withErrors([
            'email' => 'O email ou a senha fornecidos não são válidos.',
        ]);
    }
     /**
    * Outros métodos não utilizados
     */
    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
