<?php


namespace App\Repositories\Iscas;

use App\Models\Technologie;
use App\Repositories\AbstractRepository;

class TechnologieRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Technologie $model
     */
    public function __construct(Technologie $model)
    {
        $this->model = $model;
    }

}
