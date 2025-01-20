<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';  // Continuamos utilizando a tabela 'users'

    // Atributos preenchíveis

    // Define qual é a chave primária
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'level',
        'created_at',
    ];

    public $timestamps = false;

    // Atributos que não são visíveis no array ou JSON
    protected $hidden = [
        'password', // Garantir que a senha nunca seja exposta
        'remember_token',
    ];

    // Aqui podemos manter se precisar usar esse modelo, mas sem métodos Eloquent
    // O acesso direto ao banco é feito via SQL
    // Função para criar um novo usuário com SQL direto
    public static function createUser($data)
    {
        // Insere um novo usuário utilizando SQL direto
        return DB::insert(
            'INSERT INTO users (name, email, password, role, level, created_at)
             VALUES (?, ?, ?, ?, ?, ?)',
            [
                $data['name'],
                $data['email'],
                bcrypt($data['password']), // Garantir a senha criptografada
                $data['role'],
                $data['level'],
                now()  // Data e hora atual
            ]
        );
    }

    // Função para buscar todos os usuários com SQL direto
    public static function getAllUsers()
    {
        // Seleciona todos os usuários utilizando SQL direto
        return DB::select('SELECT * FROM users');
    }

    public static function getUserByEmail($email) {
        return DB::select('SELECT * FROM users WHERE email = ?', [$email]);
    }

    // Função para encontrar um usuário por ID com SQL direto
    public static function getUserById($id)
{
    return DB::select('SELECT * FROM users WHERE id_user = ?', [$id]);
}

    // Função para atualizar os dados de um usuário com SQL direto
    public static function updateUser($id, $data)
    {
        // Atualiza os dados de um usuário utilizando SQL direto
        return DB::update(
            'UPDATE users SET name = ?, email = ?, password = ?, role = ?, level = ?, updated_at = ?
             WHERE id_user = ?',
            [
                $data['name'],
                $data['email'],
                isset($data['password']) ? bcrypt($data['password']) : null, // Se não for passada uma nova senha, ela não será alterada
                $data['role'],
                $data['level'],
                now(), // Data e hora da última atualização
                $id
            ]
        );
    }

    // Função para excluir um usuário com SQL direto
    public static function deleteUser($id)
    {
        // Exclui um usuário com SQL direto
        return DB::delete('DELETE FROM users WHERE id_user = ?', [$id]);
    }
}
