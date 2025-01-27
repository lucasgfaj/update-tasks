<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;
use App\Models\User;

// Página inicial - Login
Route::get('/', [AuthController::class, 'index'])->name('home');

// Grupo de rotas de autenticação
Route::prefix('auth')->name('auth.')->group(function () {
    // Rota para registrar o usuário
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserController::class, 'register']);

    // Rota para login do usuário
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserController::class, 'login']);

    // Rota para logout do usuário
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Rotas protegidas para usuários autenticados
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [TasksController::class, 'dashboard'])->name('dashboard');

    // Rota para criar uma nova tarefa
    Route::get('/tasks/create', [TasksController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TasksController::class, 'store'])->name('tasks.store');

    // Rota para exibir detalhes de uma tarefa
    Route::get('/tasks/{id}', [TasksController::class, 'show'])->name('tasks.show');

    // Rota para editar uma tarefa
    Route::get('/tasks/{id}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{id}', [TasksController::class, 'update'])->name('tasks.update');

    // Rota para deletar uma tarefa
    Route::delete('/tasks/delete/{id}', [TasksController::class, 'destroy'])->name('tasks.destroy');

    // Rota para editar usuário
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');

    // Rota para atualizar os dados do usuário
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');

    // Rota para deletar usuário
    Route::delete('/user/delete/{id}', [UserController::class, 'deleteUser'])->name('user.delete');

    // Rota para exibir detalhes do time
    Route::get('/teams/show/{id}', [TeamsController::class, 'show'])->name('teams.show');

    Route::get('/teams/create', [TeamsController::class, 'create'])->name('teams.create');

    Route::post('/teams/store', [TeamsController::class, 'store'])->name('teams.store');

    Route::get('/teams/edit/{id?}', [TeamsController::class, 'edit'])->name('teams.edit');

    Route::put('/teams/update/{id?}', [TeamsController::class, 'update'])->name('teams.update');

    Route::delete('/teams/delete/{id}', [TeamsController::class, 'delete'])->name('teams.delete');

    // Team
    Route::get('/teams', [TeamsController::class, 'teams'])->name('teams');

    // Rota para exibir todos os comentários
    Route::get('/comments', [CommentController::class, 'comments'])->name('comments');

    // Rota para criar um novo comentário
    Route::get('/comments/create', [CommentController::class, 'create'])->name('comments.create');

    // Rota para salvar um comentário
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

    // Rota para exibir detalhes de um comentário
    Route::get('/comments/{id}', [CommentController::class, 'show'])->name('comments.show');

    // Rota para editar um comentário
    Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');

    // Rota para atualizar um comentário
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');

    // Rota para deletar um comentário
    Route::delete('/comments/delete/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

});
