<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    // Definindo a tabela associada
    protected $table = 'tasks';

    // Definindo a chave primária
    protected $primaryKey = 'id_tasks';

    // Habilitar auto-incremento
    public $incrementing = true; // A chave primária está configurada como serial no banco de dados.

    // Campos que podem ser preenchidos
    protected $fillable = [
        'name',
        'team_id',
        'description',
        'priority',
        'status',
        'creation_date',
        'due_date',
    ];

    // Relacionamento com a tabela 'teams'
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id_teams');
    }

    // Você pode adicionar mais métodos para relações com outras tabelas, caso haja outros relacionamentos.
}
