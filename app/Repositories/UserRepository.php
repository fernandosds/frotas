<?php


namespace App\Repositories;

use App\User;

class UserRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getAllAdmins()
    {
        return $this->model->where("type", '=', 'sat')
                        ->where('status', 1)
                        ->where('access_level', '=', 'management')
                        ->get();
    }

}
