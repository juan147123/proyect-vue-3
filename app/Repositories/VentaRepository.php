<?php

namespace App\Repositories;

use App\Models\Venta;
use App\Interfaces\VentaRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class VentaRepository extends BaseRepository implements VentaRepositoryInterface
{

    protected $model;

    public function __construct(Venta $model)
    {
        $this->model = $model;
    }
}
