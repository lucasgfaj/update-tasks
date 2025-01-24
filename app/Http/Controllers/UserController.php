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
            'role' => '',
            'experience' => 'Junior',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        // Chama o método de criação no modelo User
        User::create($data);

        return redirect()->route('auth.login')->with('success', 'Registro realizado com sucesso!');
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

    // Exibe o formulário de edição do usuário
    public function edit($id)
    {
        $user = User::getUserById($id); // Busca o usuário pelo ID
        if ($user) {
            return view('user.edit', ['user' => $user[0]]); // Passa o usuário para a view
        }
        return redirect()->route('dashboard')->with('error', 'Usuário não encontrado!');
    }

    // Atualiza os dados do usuário
    public function update(Request $request, $id_user)
{
    // Valida os dados
    $request->validate([
        'name' => 'required|string|max:400',
        'email' => 'required|string|email|max:400|unique:users,email,' . $id_user . ',id_user', // Corrigido para 'email,' . $id_user
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    // Prepara os dados para atualização
    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'role' => '', // ou algum valor predefinido
        'experience' => 'Junior', // ou algum valor predefinido
    ];

    // Se a senha for fornecida, inclui no array
    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    // Atualiza os dados do usuário
    User::updateUser($id_user, $data);

    return redirect()->route('user.edit', $id_user)->with('success', 'Dados atualizados com sucesso!');
}

    public function dashboard()
    {
        // Buscar todos os usuários
        $users = User::getAllUsers();

        // Passar a variável $users para a view
        return view('dashboard.index', compact('users'));
    }
}
