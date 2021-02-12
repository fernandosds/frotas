<?php


namespace App\Repositories\Iscas;

use App\Models\AccommodationLocation;
use App\Repositories\AbstractRepository;

class AccommodationLocationsRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param AccommodationLocation $model
     */
    public function __construct(AccommodationLocation $model)
    {
        $this->model = $model;
    }


}
