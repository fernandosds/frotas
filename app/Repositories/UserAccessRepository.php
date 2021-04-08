<?php


namespace App\Repositories;

use App\Models\UserMenu;
use App\User;

class UserAccessRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param UserMenu $model
     */
    public function __construct(UserMenu $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function findByUserId($id)
    {
        $userId = $this->model
            ->where('user_id', '=', $id)
            ->first();

        return $userId;
    }
}
