<?php


namespace App\Repositories\Rent;

use Illuminate\Support\Facades\DB;
use App\Models\Rent\Cost;
use App\Repositories\AbstractRepository;

class CostRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Cost $model
     */
    public function __construct(Cost $model)
    {
        $this->model = $model;
    }
}
