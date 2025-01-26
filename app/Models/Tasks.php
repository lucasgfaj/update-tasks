<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tasks extends Model
{
    use \Illuminate\Notifications\Notifiable;


    // Definindo a tabela Tasks
    protected $table = 'tasks';

    // Definindo a chave primária da tabela
    protected $primaryKey = 'id_tasks';


    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'name',
        'team_id',
        'description',
        'priority',
        'status',
        'start_date',
        'end_date',
    ];

    // Define se a tabela usa timestamps automáticos
    public $timestamps = true;

    // Oculta campos sensíveis quando o modelo é convertido em JSON ou array
    protected $hidden = [
        'created_at',
        'updated_at',
        'remember_token',
    ];

    // Relacionamento com a tabela 'teams'
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id_teams');
    }

    // Cria uma nova tarefa
    public static function createTask($data)
    {
        return DB::insert(
            'INSERT INTO tasks (name, team_id, description, priority, status, start_date, end_date, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $data['name'],          // Nome da tarefa
                $data['team_id'],       // ID do time
                $data['description'],   // Descrição
                $data['priority'],      // Prioridade
                $data['status'],        // Status
                $data['start_date'],    // Data de início
                $data['end_date'],      // Data de término
                now(),    // Data de criação
            ]
        );
    }


     // Retorna todas as tarefas

     public static function getAllTasks()
     {
         return DB::select('SELECT * FROM tasks ORDER BY start_date DESC');
     }

     // Retorna uma tarefa específica pelo ID

    public static function getTask($id)
    {
        return DB::select('SELECT * FROM tasks WHERE id_tasks = ?', [$id]);
    }


    // Atualiza uma tarefa

    public static function updateTask($data)
    {
        return DB::update(
            'UPDATE tasks SET name = ?, team_id = ?, description = ?, priority = ?, status = ?, start_date = ?, end_date = ?, updated_at = ?
             WHERE id_tasks = ?',
            [
                $data['name'],          // Nome da tarefa
                $data['team_id'],       // ID do time
                $data['description'],   // Descrição
                $data['priority'],      // Prioridade
                $data['status'],        // Status
                $data['start_date'],    // Data de início
                $data['end_date'],      // Data de término
                $id,                    // ID da tarefa
                ]
        );
    }

     // Deleta uma tarefa

     public static function deleteTask($id)
     {
         return DB::delete('DELETE FROM tasks WHERE id_tasks = ?', [$id]);
     }


    // Retorna todas as tarefas de um time específico

    public static function getTasksByTeam($team_id)
    {
        return DB::select('SELECT * FROM tasks WHERE team_id = ? ORDER BY start_date DESC', [$team_id]);
    }

    // Retorna uma tarefa pelo ID

    public static function getTaskById($id)
    {
        return DB::select('SELECT * FROM tasks WHERE id_tasks = ?', [$id]);
    }

    // Filtra tarefas

    public static function filterTasks($filters)
    {
        $query = DB::table('tasks')
            ->select(
                'tasks.*',
                'teams.name as team_name',
                'teams.type as team_type',
                'teams.responsible_id as team_responsible_id',
                'users.name as responsible_name'
            )
            ->leftJoin('teams', 'tasks.team_id', '=', 'teams.id_teams')
            ->leftJoin('users', 'teams.responsible_id', '=', 'users.id_user');

        if (isset($filters['team_id'])) {
            $query->where('tasks.team_id', $filters['team_id']);
        }

        if (isset($filters['status'])) {
            $query->where('tasks.status', $filters['status']);
        }

        if (isset($filters['priority'])) {
            $query->where('tasks.priority', $filters['priority']);
        }

        if (isset($filters['start_date'])) {
            $query->where('tasks.start_date', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date'])) {
            $query->where('tasks.end_date', '<=', $filters['end_date']);
        }

        return $query->distinct();
    }

}
