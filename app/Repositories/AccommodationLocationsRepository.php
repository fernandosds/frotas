<?php


namespace App\Repositories;

use App\Models\AccommodationLocation;

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
