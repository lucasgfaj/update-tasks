<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Models\Teams;
use App\Models\User;


class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function dashboard(Request $request)
     {
         // Recuperar os filtros da requisição, exceto o campo "page"
         $filters = $request->except('page');

         // Recuperar as listas necessárias
         $users = User::getAllUsers();
         $teams = Teams::getAllTeams();

         // Buscar tarefas com ou sem filtros
         $tasksQuery = Tasks::filterTasks($filters);
         $tasks = $tasksQuery->paginate(10);

         return view('dashboard.index', compact('tasks', 'teams', 'filters', 'users'));
     }

    public function store(Request $request)
    {
        // Validate the data
        $request->validate([
            'name' => 'required|string|max:400',
            'team_id' => 'required|integer',
            'description' => 'required|string',
            'priority' => 'required|string',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Prepare the data for insertion
        $data = [
            'name' => $request->name,
            'team_id' => $request->team_id,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        // Call the creation method in the Task model
        Tasks::createTask($data);

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');
    }

    public function edit($id = null)
    {
        if ($id) {
            $task = Tasks::getTaskById($id);
            $teams = Teams::getAllTeams();
            return view('tasks.edit', compact('task', 'teams'));


            if (!$task) {
                return redirect()->route('dashboard')->with('error', 'Tarefa não encontrada');
            }
            return view('tasks.edit', compact('task'));
        }
        return view('tasks.edit', compact('task'));
    }

    public function show($id)
    {
        // Get the task by ID
        $task = Tasks::getTaskById($id);

        // Pass the $task variable to the view
        return view('dashboard', ['task' => $task[0]]);
    }

    public function update(Request $request, $id = null)
    {
        // Validate the data
        $validatedData = $request->validate([
            'name' => 'required|string|max:400',
            'team_id' => 'required|integer',
            'description' => 'required|string',
            'priority' => 'required|string',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Call the update method in the Task model
        Tasks::updateTask($validatedData, $id);

        return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
    }


    public function destroy($id)
    {
        Tasks::deleteTask($id);
        return redirect()->route('dashboard')->with('success', 'Task deleted successfully!');
    }
}
