<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\SupplierRepositoryInterface;
use App\Interfaces\TiposRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    private $repository;
    private $repositoryProveedor;
    private $repositoryTipos;

    public function __construct(
        ProductRepositoryInterface $repository,
        SupplierRepositoryInterface $repositoryProveedor,
        TiposRepositoryInterface $repositoryTipos
    ) {
        $this->repository = $repository;

        $this->repositoryProveedor = $repositoryProveedor;
        $this->repositoryTipos = $repositoryTipos;
    }

    public function redirectPageProducts()
    {
        $data =  array(
            "proveedores" => $this->repositoryProveedor->all(),
            "productos" => $this->repositoryTipos->getTipoByUso('fruta'),
            "unidades" => $this->repositoryTipos->getTipoByUso('unidad')
        );
        return Inertia::render('Productos/Index')->with("data", $data);
    }

    public function listAll()
    {
        return $this->repository->all(['*'], ['productsTipo', 'productsUM', 'supplier']);
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
