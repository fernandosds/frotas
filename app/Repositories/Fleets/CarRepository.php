<?php


namespace App\Repositories\Fleets;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Car;
use App\Repositories\AbstractRepository;
use mysql_xdevapi\Schema;

class CarRepository extends AbstractRepository
{


    /**
     * UserRepository constructor.
     * @param Car $model
     *
     *
     */
    public function __construct(Car $model)
    {
        $this->model = $model;
    }

    /**
     * @param $used
     * @return mixed
     */
    public function getAvailableCars($used)
    {
        return $this->model->where('customer_id', Auth::user()->customer_id)
            ->whereNotIn('id', $used)
            ->get();
    }
}
