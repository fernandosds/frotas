<?php


namespace App\Repositories\Rent;

use Illuminate\Support\Facades\DB;
use App\Models\Rent\Driver;
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
}
