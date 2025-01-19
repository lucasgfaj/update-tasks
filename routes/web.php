<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
Route::middleware('auth')->group(function() {
    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Rota para editar usuário
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');

    // Rota para deletar usuário
    Route::delete('/user/delete/{id}', [UserController::class, 'deleteUser'])->name('user.delete');
});
