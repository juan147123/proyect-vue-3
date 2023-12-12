<?php

namespace App\Http\Controllers;

use App\Interfaces\SupplierRepositoryInterface;
use App\Interfaces\TiposRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TiposController extends Controller
{

    private $repository;

    public function __construct(
        TiposRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }

    public function redirectPageTipos()
    {
        return Inertia::render('Configuraciones/Index');
    }
    public function listAll($uso)
    {
        return $this->repository->getTipoByUso($uso);
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
