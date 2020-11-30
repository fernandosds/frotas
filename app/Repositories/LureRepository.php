<?php


namespace App\Repositories;

use App\Models\Lure;

class LureRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Lure $model
     */
    public function __construct(Lure $model)
    {
        $this->model = $model;
    }

}
