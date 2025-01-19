<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;

class TeamProject
{
    // Nome da tabela associada
    protected $table = 'teams_projects';

    // Define a chave primária
    protected $primaryKey = 'id_team_project';

    // Atributos preenchíveis
    protected $fillable = [
        'name',
        'description',
        'id_manager',
        'type',
        'status',
        'start_date',
        'end_date',
        'created_at',
    ];

    /**
     * Retorna todos os registros da tabela.
     *
     * @return array
     */
    public static function all()
    {
        return DB::select("SELECT * FROM teams_projects");
    }

    /**
     * Insere um novo registro na tabela.
     *
     * @param array $data
     * @return bool
     */
    public static function create(array $data)
    {
        return DB::insert(
            "INSERT INTO teams_projects (name, description, id_manager, type, status, start_date, end_date, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['name'],
                $data['description'],
                $data['id_manager'],
                $data['type'],
                $data['status'],
                $data['start_date'],
                $data['end_date'],
                $data['created_at'] ?? now(), // Usa a data atual se não fornecida
            ]
        );
    }

    /**
     * Encontra um registro pelo ID.
     *
     * @param int $id
     * @return object|null
     */
    public static function find(int $id)
    {
        $result = DB::select(
            "SELECT * FROM teams_projects WHERE id_team_project = ? LIMIT 1",
            [$id]
        );

        return $result[0] ?? null;
    }

    /**
     * Atualiza um registro específico pelo ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function update(int $id, array $data)
    {
        return DB::update(
            "UPDATE teams_projects SET name = ?, description = ?, id_manager = ?, type = ?, status = ?, start_date = ?, end_date = ? WHERE id_team_project = ?",
            [
                $data['name'],
                $data['description'],
                $data['id_manager'],
                $data['type'],
                $data['status'],
                $data['start_date'],
                $data['end_date'],
                $id,
            ]
        );
    }

    /**
     * Exclui um registro pelo ID.
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id)
    {
        return DB::delete(
            "DELETE FROM teams_projects WHERE id_team_project = ?",
            [$id]
        );
    }
}
