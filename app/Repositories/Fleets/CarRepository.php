<?php


namespace App\Repositories\Fleets;

use Illuminate\Support\Facades\DB;
use App\Models\Car;
use App\Repositories\AbstractRepository;

class CarRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Car $model
     *
     */
    public function __construct(Car $model)
    {
        $this->model = $model;
    }
}
