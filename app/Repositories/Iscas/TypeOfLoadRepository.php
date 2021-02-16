<?php


namespace App\Repositories\Iscas;

use App\Models\TypeOfLoad;
use App\Repositories\AbstractRepository;

class TypeOfLoadRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param TypeOfLoad $model
     */
    public function __construct(TypeOfLoad $model)
    {
        $this->model = $model;
    }

}
