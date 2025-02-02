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
            'role' => $request->role, // ou algum valor predefinido
            'experience' => $request->experience,
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
        'role' => $request->role, // ou algum valor predefinido
        'experience' => $request->experience, // ou algum valor predefinido
    ];

    // Se a senha for fornecida, inclui no array
    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    // Atualiza os dados do usuário
    User::updateUser($id_user, $data);

    return redirect()->route('user.edit', $id_user)->with('success', 'Dados atualizados com sucesso!');
}

    // Exclui um usuário
    public function destroy($id)
    {
        User::deleteUser($id); // Chama o método no modelo

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }


    public function index(Request $request)
    {
        // Obtém os filtros da requisição, exceto o parâmetro de página
        $filters = $request->except('page');

        // Verifica se o usuário está autenticado e possui permissão
        if (!Auth::check() || auth()->user()->role !== 'Admin') {
            abort(403, 'Acesso negado.');
        }

        // Aplica os filtros na query
        $usersQuery = User::filterUsers($filters);

        // Realiza a paginação, mantendo os filtros na URL
        $users = $usersQuery->paginate(10)->appends($filters);

        // Retorna a view com os dados
        return view('users.index', compact('users', 'filters'));
    }

    public function editusers($id)
{
    // Busca o usuário pelo ID
    $user = User::findOrFail($id);

    // Retorna a view com o usuário
    return view('users.edit', compact('user'));
}

    public function store(Request $request){

        if (!Auth::check() || auth()->user()->role !== 'Admin') {
            return response()->json(['error' => 'Acesso negado. Apenas administradores podem realizar esta ação.'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:400',
            'email' => 'required|string|email|max:400|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'O e-mail informado já está em uso.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Criptografa a senha
            'role' => $request->role,
            'experience' => $request->experience,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        User::create($data);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

      // Atualiza os dados do usuário
      public function updateUsers(Request $request, $id_user)
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
              'role' => $request->role, // ou algum valor predefinido
              'experience' => $request->experience, // ou algum valor predefinido
          ];

          // Se a senha for fornecida, inclui no array
          if ($request->filled('password')) {
              $data['password'] = bcrypt($request->password);
          }

          // Atualiza os dados do usuário
          User::updateUser($id_user, $data);

          return redirect()->route('users.index', $id_user)->with('success', 'Dados atualizados com sucesso!');
      }




}
