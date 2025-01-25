<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teams;
use App\Models\User;

class TeamsController extends Controller
{
    /**
     * Rota Team
     */
    public function teams(Request $request)
    {
        $filters = $request->except('page');

        // Checar se filtros estão presentes e aplicar a lógica correta
        if (!empty($filters)) {
            $teams = Teams::filterTeams($filters)->paginate(10); // Se houver filtros
        } else {
            $teams = Teams::paginate(10); // Sem filtros
        }

        $users = User::getAllUsers();
        return view('teams.index', compact('teams', 'users', 'filters'));
    }

    public function store(Request $request) {
        // Valida os dados
        $request->validate([
            'name' => 'required|string|max:400',
            'responsible_id' => 'required|integer',
            'type' => 'required|string|max:100',
            'description' => 'required|string',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Prepara os dados para inserção
        $data = [
            'name' => $request->name,
            'responsible_id' => $request->responsible_id,
            'type' => $request->type,
            'description' => $request->description,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        // Chama o método de criação no modelo Team
        Teams::createTeam($data);

        return redirect()->route('teams')->with('success', 'Time criado com sucesso!');
    }

    public function edit($id = null) {
        if ($id) {
            $team = Teams::getTeamById($id);

            if (!$team) {
                return redirect()->route('teams.index')->with('error', 'Time não encontrado.');
            }

            return view('teams.edit', compact('team'));
        }
        return view('teams.edit', compact('team'));
    }

    public function show($id) {
        // Buscar o time pelo ID
        $team = Teams::getTeamById($id);

        // Passar a variável $team para a view
        return view('teams',  ['team' => $team[0]]);
    }

    public function update(Request $request, $id = null) {
        // Valida os dados
        $request->validate([
            'name' => 'required|string|max:400',
            'responsible_id' => 'required|integer',
            'type' => 'required|string|max:100',
            'description' => 'required|string',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Atualiza os dados do time
        Teams::updateTeam($id, $request->all());

        return redirect()->route('teams')->with('success', 'Time atualizado com sucesso!');
    }

    public function delete($id) {
        // Deleta o time
       $team = Teams::deleteTeam($id);
        if($team) {
            return redirect()->route('teams')->with('success', 'Time deletado com sucesso!');
        }

        return redirect()->route('teams')->with('error', 'Erro ao deletar o time!');}

}
