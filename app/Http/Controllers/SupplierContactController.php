<?php

namespace App\Http\Controllers;

use App\Interfaces\SupplierContactRepositoryInterface;
use Illuminate\Http\Request;

class SupplierContactController extends Controller
{
    private $repository;

    public function __construct(SupplierContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function listAll()
    {
        return $this->repository->all();
    }
    public function getAllBySuppId($id)
    {
        return $this->repository->getAllBySuppId($id);
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
