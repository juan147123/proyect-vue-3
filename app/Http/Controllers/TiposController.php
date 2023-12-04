<?php

namespace App\Http\Controllers;

use App\Interfaces\TiposRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TiposController extends Controller
{

    private $repository;

    public function __construct(TiposRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function redirectPageTipos($tipo)
    {
        return Inertia::render('Configuraciones/Index', ["tipos" => $tipo]);
    }
    public function listAll()
    {
        return $this->repository->all();
    }
    public function create(Request $request)
    {
        return $this->repository->create($request->all());
    }
    public function update($id, Request $request)
    {
        return $this->repository->update($id, $request->all());
    }
    public function delete($id)
    {
        return $this->repository->update($id, ["enable" => 0]);
    }
}
