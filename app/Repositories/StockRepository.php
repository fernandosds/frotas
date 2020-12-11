<?php


namespace App\Repositories;

use App\Models\Stock;

class StockRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Stock $model
     */
    public function __construct(Stock $model)
    {
        $this->model = $model;
    }

}
