<?php

use App\Http\Controllers\{
    ProductController,
    SupplierContactController,
    UserController,
    SupplierController,
    TiposController
};
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

    //PROVEEDORES
    Route::get('proveedores', [SupplierController::class, 'redirectPageSuppliers'])->name('proveedores');
    Route::get('proveedores/list', [SupplierController::class, 'listAll'])->name('proveedores.list');
    Route::post('proveedores/create', [SupplierController::class, 'create'])->name('proveedores.create');
    Route::put('proveedores/update/{id}', [SupplierController::class, 'update'])->name('proveedores.update');
    Route::put('proveedores/delete/{id}', [SupplierController::class, 'delete'])->name('proveedores.delete');
    
    //CONTACTOS PROVEEDOR
    Route::get('proveedores/contact/list', [SupplierContactController::class, 'listAll'])->name('proveedores.contact.list');
    Route::get('proveedores/contact/list/all/{id}', [SupplierContactController::class, 'getAllBySuppId'])->name('proveedores.contact.list');
    Route::post('proveedores/contact/create', [SupplierContactController::class, 'create'])->name('proveedores.contact.create');
    Route::put('proveedores/contact/update/{id}', [SupplierContactController::class, 'update'])->name('proveedores.contact.update');
    Route::put('proveedores/contact/delete/{id}', [SupplierContactController::class, 'delete'])->name('proveedores.contact.delete');
    
    //TIPOS
    Route::get('configuraciones/{tipo}', [TiposController::class, 'redirectPageTipos'])->name('configuraciones.redirect');
    Route::get('configuraciones/all/{tipo}', [TiposController::class, 'listAll'])->name('configuraciones.list');
    Route::post('configuraciones/create', [TiposController::class, 'create'])->name('configuraciones.create');
    Route::put('configuraciones/update/{id}', [TiposController::class, 'update'])->name('configuraciones.update');
    Route::put('configuraciones/delete/{id}', [TiposController::class, 'delete'])->name('configuraciones.delete');

    //PRODUCTOS
    Route::get('productos', [ProductController::class, 'redirectPageProducts'])->name('productos.redirect');
    Route::get('productos/all', [ProductController::class, 'listAll'])->name('productos.list');
    Route::post('productos/create', [ProductController::class, 'create'])->name('productos.create');
    Route::put('productos/update/{id}', [ProductController::class, 'update'])->name('productos.update');
    Route::put('productos/delete/{id}', [ProductController::class, 'delete'])->name('productos.delete');
    
    
});
