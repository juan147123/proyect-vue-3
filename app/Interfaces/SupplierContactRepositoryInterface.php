<?php

namespace App\Interfaces;

interface SupplierContactRepositoryInterface extends EloquentRepositoryInterface
{
    public function getAllBySuppId($id);
}
