<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Interfaces\SupplierRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class SupplierRepository extends BaseRepository implements SupplierRepositoryInterface
{
    
    protected $model;

    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }

}
