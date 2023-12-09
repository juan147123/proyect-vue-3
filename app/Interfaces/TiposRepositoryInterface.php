<?php

namespace App\Interfaces;

interface TiposRepositoryInterface extends EloquentRepositoryInterface
{
    public function getTipoByUso($uso);
}
