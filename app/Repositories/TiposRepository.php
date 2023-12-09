<?php

namespace App\Repositories;

use App\Models\Tipos;
use App\Interfaces\TiposRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class TiposRepository extends BaseRepository implements TiposRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Tipos $model)
    {
        $this->model = $model;
    }

    public function getTipoByUso($uso)
    {
        return $this->model->where('uso', $uso)->get();
    }
}
