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
    public function teams()
    {
    // Buscar todos os times
    $teams = Teams::getAllTeams();

    // Recupera todos os usuários usando o método all(), que retorna todos os registros
    $users = User::getAllUsers(); // Ou User::get()

    // Passar as variáveis $teams e $users para a view
    return view('teams.index', compact('teams', 'users'));
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

    public function edit($id) {
        // Buscar o time pelo ID
        $team = Teams::getTeamById($id);

        // Se o time for uma coleção, garantir que é um único time
        if (!$team || $team->isEmpty()) {
            // Se não houver time, redireciona com mensagem de erro
            return redirect()->route('teams.index')->with('error', 'Time não encontrado.');
        }

        // Caso o time tenha sido encontrado, passa ele para a view
        return view('teams.edit', compact('team'));
    }

    public function show($id) {
        // Buscar o time pelo ID
        $team = Teams::getTeamById($id);

        // Passar a variável $team para a view
        return view('teams',  ['team' => $team[0]]);
    }

    public function update (Request $request, $id) {
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

        // Prepara os dados para atualização
        $data = [
            'name' => $request->name,
            'responsible_id' => $request->responsible_id,
            'type' => $request->type,
            'description' => $request->description,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        // Atualiza os dados do time
        Teams::updateTeam($id, $data);

        return redirect()->route('teams', $id)->with('success', 'Time atualizado com sucesso!');
    }

    public function delete($id) {
        // Deleta o time
       $team = Teams::deleteTeam($id);
        if($team) {
            return redirect()->route('teams')->with('success', 'Time deletado com sucesso!');
        }

        return redirect()->route('teams')->with('error', 'Erro ao deletar o time!');}

}
