<?php

namespace App\Repositories;

use App\Models\SupplierContact;
use App\Interfaces\SupplierContactRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class SupplierContactRepository extends BaseRepository implements SupplierContactRepositoryInterface
{

    protected $model;

    public function __construct(SupplierContact $model)
    {
        $this->model = $model;
    }

    public function getAllBySuppId($id)
    {
        return $this->model->where("enable", 1)->where("supplier_id", $id)->get();
    }
}
