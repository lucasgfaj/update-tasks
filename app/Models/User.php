<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    // Atributos que não são visíveis no array ou JSON
    protected $hidden = [
        'password', // Garantir que a senha nunca seja exposta
        'remember_token',
    ];

    // Aqui podemos manter se precisar usar esse modelo, mas sem métodos Eloquent
    // O acesso direto ao banco é feito via SQL
}
