<?php

namespace App\Repositories;

use App\Models\DetalleVenta;
use App\Interfaces\DetalleVentaRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class DetalleVentaRepository extends BaseRepository implements DetalleVentaRepositoryInterface
{

    protected $model;

    public function __construct(DetalleVenta $model)
    {
        $this->model = $model;
    }
}
