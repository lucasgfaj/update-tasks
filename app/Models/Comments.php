<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comments extends Model
{
    use \Illuminate\Notifications\Notifiable;


    // Definindo a tabela Comments
    protected $table = 'comments';

    // Definindo a chave primária da tabela
    protected $primaryKey = 'id_comments';


    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'type',
        'task_id',
        'user_id',
        'team_id',
        'description',
        'created_at'
    ];

    // Define se a tabela usa timestamps automáticos
    public $timestamps = true;

    // Oculta campos sensíveis quando o modelo é convertido em JSON ou array
    protected $hidden = [
        'remember_token',
    ];

    // Relacionamento com a tabela 'tasks'
    public function task()
    {
        return $this->belongsTo(Tasks::class, 'task_id', 'id_tasks');
    }

    // Cria um novo comentário
    public static function createComment($data)
    {
        return DB::insert(
            'INSERT INTO comments (type, task_id, user_id, team_id, description, created_at)
             VALUES (?, ?, ?, ?, ?, ?)',
            [
                $data['type'],          // Tipo do comentário
                $data['task_id'],       // ID da tarefa
                $data['user_id'],       // ID do usuário
                $data['team_id'],       // ID do time
                $data['description'],   // Descrição
                now(),    // Data de criação
            ]
        );
    }

    // Retorna todos os comentários

    public static function getAllComments()
    {
        return DB::select('SELECT * FROM comments ORDER BY created_at DESC');
    }

    // Atualiza um comentário
    public static function updateComment(array $data, int $id)
    {
        return DB::update(
            'UPDATE comments
             SET type = ?, task_id = ?, user_id = ?, team_id = ?, description = ?
             WHERE id_comments = ?',
            [
                $data['type'],          // Tipo do comentário
                $data['task_id'],       // ID da tarefa
                $data['user_id'],       // ID do usuário
                $data['team_id'],       // ID do time
                $data['description'],   // Descrição
                $id
            ]
        );
    }

    // Deleta um comentário
    public static function deleteComment($id)
    {
        return DB::delete('DELETE FROM comments WHERE id_comments = ?', [$id]);
    }

    // Retorna todos os comentários de uma tarefa específica
    public static function getCommentsByTask($task_id)
    {
        return DB::select('SELECT * FROM comments WHERE task_id = ? ORDER BY created_at DESC', [$task_id]);
    }

    // Retorna um comentário pelo ID
    public static function getCommentById($id)
    {
        return DB::select('SELECT * FROM comments WHERE id_comments = ?', [$id]);
    }

    // Filtra comentários
    public static function filterComments($filters)
    {
        $query = DB::table('comments')
            ->select(
                'comments.*',
                'tasks.name as task_name',
                'users.name as user_name',
                'teams.name as team_name' // Adicionado o filtro de equipe também
            )
            ->leftJoin('tasks', 'comments.task_id', '=', 'tasks.id_tasks')
            ->leftJoin('users', 'comments.user_id', '=', 'users.id_user')
            ->leftJoin('teams', 'comments.team_id', '=', 'teams.id_teams'); // Verifica a associação da equipe

        // Filtro de tarefa
        if (isset($filters['task']) && $filters['task'] != "") {
            $query->where('comments.task_id', $filters['task']);
        }

        // Filtro de usuário
        if (isset($filters['user']) && $filters['user'] != "") {
            $query->where('comments.user_id', $filters['user']);
        }

        // Filtro de time
        if (isset($filters['team']) && $filters['team'] != "") {
            $query->where('comments.team_id', $filters['team']);
        }

        // Filtro de tipo
        if (isset($filters['type']) && $filters['type'] != "") {
            $query->where('comments.type', $filters['type']);
        }

        // Filtro de data de início
        if (isset($filters['start_date']) && $filters['start_date'] != "") {
            $query->where('comments.created_at', '>=', $filters['start_date']);
        }

        // Filtro de data de fim
        if (isset($filters['end_date']) && $filters['end_date'] != "") {
            $query->where('comments.created_at', '<=', $filters['end_date']);
        }

        return $query->distinct();
    }
}
