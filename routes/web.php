<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;

// Página inicial - Login
Route::get('/', [AuthController::class, 'index'])->name('home');

// Grupo de rotas de autenticação
Route::prefix('auth')->name('auth.')->group(function() {
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
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Rota para listar usuários
    Route::get('/users', [UserController::class, 'index'])->name('users');
    // Rota para editar usuário
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');

    // Rota para atualizar os dados do usuário
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');

    // Rota para deletar usuário
    Route::delete('/user/delete/{id}', [UserController::class, 'deleteUser'])->name('user.delete');

    Route::get('/teams/create', [TeamsController::class, 'create'])->name('teams.create');

    Route::post('/teams/store', [TeamsController::class, 'store'])->name('teams.store');

    Route::get('/teams/edit/{id}', [TeamsController::class, 'edit'])->name('teams.edit');

    Route::put('/teams/update/{id}', [TeamsController::class, 'update'])->name('teams.update');

    Route::delete('/teams/delete/{id}', [TeamsController::class, 'delete'])->name('teams.delete');

    // Team
    Route::get('/teams', [TeamsController::class, 'teams'])->name('teams');

    // Comments
    Route::get('/comments', [CommentController::class, 'comment'])->name('comment');

    // Admin (protegido para admin apenas)
    Route::get('/users', function () {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Acesso negado.');
        }
        return view('users.index');
    })->name('users.index');
});
