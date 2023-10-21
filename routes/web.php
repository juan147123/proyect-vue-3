<?php

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::post('login', [UserController::class, 'login'])->name('login.user');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    //USUARIOS
    Route::get('usuarios', [UserController::class, 'getPageUsers'])->name('usuarios');
    Route::get('usuarios/list', [UserController::class, 'getAll'])->name('usuarios.list');
    Route::post('usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
    Route::put('usuarios/update', [UserController::class, 'update'])->name('usuarios.update');
    Route::put('usuarios/delete/{id}', [UserController::class, 'delete'])->name('usuarios.delete');


});
