<?php

namespace App\Http\Controllers;

use App\Interfaces\SupplierRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{
    private $repository;

    public function __construct(SupplierRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function redirectPageSuppliers()
    {
        return Inertia::render('Proveedores/Index');
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
