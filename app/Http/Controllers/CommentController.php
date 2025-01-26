<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use App\Models\Tasks;
use App\Models\User;
use App\Models\Teams;

class CommentController extends Controller
{
    // Listar Comentários (com filtros ou não)
    public function comments(Request $request)
    {
        // Recupera todos os filtros enviados no request, exceto 'page'
        $filters = $request->except('page');

        // Recupera todas as listas necessárias
        $tasks = Tasks::getAllTasks();
        $users = User::getAllUsers();
        $teams = Teams::getAllTeams();


        // Busca de comentários com ou sem filtros
        $commentsQuery = Comments::filterComments($filters);
        $comments = $commentsQuery->paginate(10);


        // Retorna a view de comentários
        return view('comments.index', compact('comments', 'tasks', 'users', 'teams', 'filters'));
    }

    // Armazenar Comentário (criar)
    public function store(Request $request)
    {
        // Valida os dados do formulário
        $request->validate([
            'type' => 'required|string',
            'task_id' => 'required|integer',
            'user_id' => 'required|integer',
            'team_id' => 'required|integer',
            'description' => 'required|string',
        ]);

        // Prepara os dados para inserção
        $data = [
            'type' => $request->type,
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
            'team_id' => $request->team_id,
            'description' => $request->description,
        ];

        // Cria o comentário com os dados
        Comments::createComment($data);

        // Redireciona com mensagem de sucesso
        return redirect()->route('comments')->with('success', 'Comment created successfully!');
    }

    // Exibir Detalhes de um Comentário
    public function show($id)
    {
        // Busca o comentário pelo ID
        $comment = Comments::getCommentById($id);

        // Retorna a view com os detalhes do comentário
        return view('comments', ['comment' => $comment[0]]);
    }

    // Exibir Formulário para Editar Comentário
    public function edit($id = null)
    {

        if ($id) {
            // Busca o comentário pelo ID
            $comment = Comments::getCommentById($id);
            $teams = Teams::getAllTeams();
            $tasks = Tasks::getAllTasks();
            $users = User::getAllUsers();

            return view('comments.edit', compact('comment', 'teams', 'tasks', 'users'));

            if (!$comment) {
                return redirect()->route('comments.index')->with('error', 'Comment not found!');
            }
            return view('comments.edit', compact('comment'));
        }
        return view('comments.edit', compact('comment'));
    }

    // Atualizar Comentário (salvar as alterações)
    public function update(Request $request, $id)
    {
        // Valida os dados de entrada
        $validatedData = $request->validate([
            'type' => 'required|string',
            'task_id' => 'required|integer',
            'user_id' => 'required|integer',
            'team_id' => 'required|integer',
            'description' => 'required|string',
        ]);


        Comments::updateComment($validatedData, $id);

        // Redireciona após a atualização com uma mensagem de sucesso
        return redirect()->route('comments')->with('success', 'Comment updated successfully!');
    }

    // Excluir Comentário
    public function destroy($id)
    {
        // Deleta o comentário pelo ID
        Comments::deleteComment($id);

        // Redireciona com uma mensagem de sucesso
        return redirect()->route('comments')->with('success', 'Comment deleted successfully!');
    }
}
