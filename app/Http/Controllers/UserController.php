<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function login(Request $request)
    {
        $user = $this->repository->findUserByEmail($request['email']);

        if (!$user) {
            return Inertia::render('Auth/Login', [
                'canLogin' => Route::has('login'),
                'laravelVersion' => Application::VERSION,
                'phpVersion' => PHP_VERSION,
                'noAuthoriced' => true
            ]);
        }

        if (Hash::check($request['password'], $user->password)) {
            Auth::login($user);
            return redirect()->route('usuarios');
        }

        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'noAuthoriced' => true
        ]);
    }
    public function getPageUsers()
    {
        return Inertia::render('Usuarios/Index');
    }
}
