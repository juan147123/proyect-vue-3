<?php

namespace App\Interfaces;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    public function findUserByEmail($email);
    public function list();
}
