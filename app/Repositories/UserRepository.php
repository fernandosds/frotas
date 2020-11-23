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
   

}
