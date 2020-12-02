<?php


namespace App\Repositories;

use App\Models\TypeOfLoad;

class TypeOfLoadRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Lure $model
     */
    public function __construct(TypeOfLoad $model)
    {
        $this->model = $model;
    }

}
