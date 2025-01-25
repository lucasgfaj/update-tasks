<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teams extends Model
{
    use \Illuminate\Notifications\Notifiable;

    // Define a tabela associada ao modelo
    protected $table = 'teams';

    // Define a chave primária da tabela
    protected $primaryKey = 'id_teams';

    // Define quais campos podem ser preenchidos em massa
    protected $fillable = [
        'name',
        'responsible_id',
        'type',
        'description',
        'status',
        'start_date',
        'end_date',
    ];

    // Define se a tabela usa timestamps automáticos
    public $timestamps = true;

    // Oculta campos sensíveis quando o modelo é convertido em JSON ou array
    protected $hidden = [
        'created_at',
        'remember_token',
    ];

    /**
     * Relacionamento: Usuário responsável por este time (users)
     */
    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id', 'id_user');
    }

    /**
     * Cria um novo time utilizando query SQL direta
     */
    public static function createTeam($data)
    {
        return DB::insert(
            'INSERT INTO teams (name, responsible_id, type, description, status, start_date, end_date, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $data['name'],          // Nome do time
                $data['responsible_id'], // ID do responsável
                $data['type'],           // Tipo de time
                $data['description'],    // Descrição
                $data['status'],         // Status do time
                $data['start_date'],     // Data de início
                $data['end_date'],       // Data de fim
                now(),                   // Data e hora atuais (created_at)
            ]
        );
    }
    /**
     * Retorna todos os times utilizando SQL direta
     */
    public static function getAllTeams()
    {
        return DB::select('SELECT * FROM teams ORDER BY start_date DESC');
    }

    /**
     * Retorna um time específico pelo ID usando SQL direta
     */
    public static function getTeam($id)
    {
        return DB::select('SELECT * FROM teams WHERE id_teams = ?', [$id]);
    }

    public static function updateTeam($id, $data)
    {
        return DB::update(
            'UPDATE teams SET name = ?, responsible_id = ?, type = ?, description = ?, status = ?, start_date = ?, end_date = ?
             WHERE id_teams = ?',
            [
                $data['name'],          // Nome do time
                $data['responsible_id'], // ID do responsável
                $data['type'],           // Tipo de time
                $data['description'],    // Descrição
                $data['status'],         // Status do time
                $data['start_date'],     // Data de início
                $data['end_date'],       // Data de fim
                $id,                     // ID do time
            ]
        );
    }

    public static function deleteTeam($id)
    {
        return DB::delete('DELETE FROM teams WHERE id_teams = ?', [$id]);
    }

    public static function getTeamById($id)
    {
        return DB::select('SELECT * FROM teams WHERE id_teams = ?', [$id]);
    }

    public static function getTeamByResponsibleId($id)
    {
        return DB::select('SELECT * FROM teams WHERE responsible_id = ?', [$id]);
    }
}
