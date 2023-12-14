<?php

namespace App\Http\Controllers;

use App\Interfaces\DetalleVentaRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DetalleVentaController extends Controller
{
    private $repository;

    public function __construct(
        DetalleVentaRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
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
