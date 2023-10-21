<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class UserRepository extends BaseRepository implements UserRepositoryInterface
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
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findUserByEmail($email)
    {
        return $this->model->where("email", $email)->first();
    }
    public function list()
    {
        return $this->model
            ->where("enable", 1)
            ->orderBy("id", "desc")
            ->get();
    }
}
