<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamProject;

class TeamProjectController extends Controller
{
    /**
     * Rota Team
     */
    public function team()
    {
        // $projects = TeamProject::all(); // Obtém todos os projetos
        // return view('team.index', ['projects' => $projects]); // Retorna para a view
        return view('team.index');
    }
}
