<?php

namespace App\Http\Controllers;

use App\Interfaces\VentaRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VentaController extends Controller
{
    private $repository;

    public function __construct(
        VentaRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }

    public function redirectPageVentas()
    {
        return Inertia::render('Ventas/Index');
    }

    public function listAll()
    {
        return $this->repository->all(['*'],['detalleVentas','detalleVentas.product']);
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
