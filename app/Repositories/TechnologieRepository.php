<?php


namespace App\Repositories;

use App\Models\Technologie;

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
