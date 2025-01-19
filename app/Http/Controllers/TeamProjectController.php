<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamProject;

class TeamProjectController extends Controller
{
    /**
     * Exibe todos os projetos.
     */
    public function index()
    {
        $projects = TeamProject::all(); // Obtém todos os projetos
        return view('projects.index', ['projects' => $projects]); // Retorna para a view
    }

    /**
     * Mostra o formulário para criar um novo projeto.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Salva um novo projeto no banco de dados.
     */
    public function store(Request $request)
    {
        // Valida os dados da requisição
        $request->validate([
            'name' => 'required|string|max:400',
            'description' => 'nullable|string',
            'id_manager' => 'required|integer',
            'type' => 'required|string|max:255',
            'status' => 'required|string|max:125',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Cria um novo projeto
        TeamProject::create([
            'name' => $request->name,
            'description' => $request->description,
            'id_manager' => $request->id_manager,
            'type' => $request->type,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('projects.index')->with('success', 'Projeto criado com sucesso!');
    }

    /**
     * Mostra os detalhes de um projeto.
     */
    public function show($id)
    {
        $project = TeamProject::find($id);

        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Projeto não encontrado!');
        }

        return view('projects.show', ['project' => $project]);
    }

    /**
     * Mostra o formulário para editar um projeto.
     */
    public function edit($id)
    {
        $project = TeamProject::find($id);

        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Projeto não encontrado!');
        }

        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Atualiza um projeto existente.
     */
    public function update(Request $request, $id)
    {
        // Valida os dados da requisição
        $request->validate([
            'name' => 'required|string|max:400',
            'description' => 'nullable|string',
            'id_manager' => 'required|integer',
            'type' => 'required|string|max:255',
            'status' => 'required|string|max:125',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Atualiza o projeto
        $updated = TeamProject::update($id, [
            'name' => $request->name,
            'description' => $request->description,
            'id_manager' => $request->id_manager,
            'type' => $request->type,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        if ($updated) {
            return redirect()->route('projects.index')->with('success', 'Projeto atualizado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao atualizar o projeto.');
        }
    }

    /**
     * Exclui um projeto do banco de dados.
     */
    public function destroy($id)
    {
        $deleted = TeamProject::delete($id);

        if ($deleted) {
            return redirect()->route('projects.index')->with('success', 'Projeto excluído com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao excluir o projeto.');
        }
    }
}
