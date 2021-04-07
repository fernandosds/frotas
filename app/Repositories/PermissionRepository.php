<?php


namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
//use App\Models\UserMenu;
use App\Models\Permission;

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

    public function updatePermission($id, $request)
    {
        $newPermission = $this->model->updateOrCreate([
            'user_id'   => $id,
        ], [
            'monitoring_id'     => $request['monitoring_id'],
            'dashboard_id'      => $request['dashboard_id'],
            'driver_id'         => $request['driver_id'],
            'fleet_car_id'      => $request['fleet_car_id'],
            'card_id'           => $request['card_id'],
            'cost_id'           => $request['cost_id']
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
