<?php


namespace App\Repositories\Rent;

use Illuminate\Support\Facades\DB;
use App\Models\Rent\Car;
use App\Repositories\AbstractRepository;

class CarRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Car $model
     */
    public function __construct(Car $model)
    {
        $this->model = $model;
    }
}
