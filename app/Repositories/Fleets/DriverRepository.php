<?php


namespace App\Repositories\Fleets;

use Illuminate\Support\Facades\DB;
use App\Models\Driver;
use App\Repositories\AbstractRepository;

class DriverRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Driver $model
     */
    public function __construct(Driver $model)
    {
        $this->model = $model;
    }

    /**
     * @param $used
     * @return mixed
     */
    public function removeCard($id)
    {
        return $this->model->where('id', $id)
            ->update(['card_id' => null]);
    }
}
