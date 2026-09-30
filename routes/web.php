<?php

use App\Http\Controllers\Admin\CondominioController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TipoCondominioController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin|editor'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::get('/condominios', [CondominioController::class, 'index'])->name('condominios.index');
        Route::post('/condominios', [CondominioController::class, 'store'])->name('condominios.store');
        Route::put('/condominios/{condominio}', [CondominioController::class, 'update'])->name('condominios.update');
        Route::delete('/condominios/{condominio}', [CondominioController::class, 'destroy'])->name('condominios.destroy');

        Route::get('/tipo-condominios', [TipoCondominioController::class, 'index'])->name('tipo-condominios.index');
        Route::post('/tipo-condominios', [TipoCondominioController::class, 'store'])->name('tipo-condominios.store');
        Route::put('/tipo-condominios/{tipoCondominio}', [TipoCondominioController::class, 'update'])->name('tipo-condominios.update');
        Route::delete('/tipo-condominios/{tipoCondominio}', [TipoCondominioController::class, 'destroy'])->name('tipo-condominios.destroy');
    });

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });

require __DIR__.'/auth.php';
