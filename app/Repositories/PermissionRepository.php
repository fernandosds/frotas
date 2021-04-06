<?php


namespace App\Repositories;


use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Permission $model
     */
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function updatePermission($id, $request)
    {

        $newPermission = $this->model->updateOrCreate([

            'user_id'   => $id,
        ], [
            'monitoring'     => $request['monitoring'],
            'dashboard'      => $request['dashboard'],
            'driver'         => $request['driver'],
            'fleet_car'      => $request['fleet_car'],
            'card'           => $request['card'],
            'cost'           => $request['cost']
        ]);
        return $newPermission;
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
