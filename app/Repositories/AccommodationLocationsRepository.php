<?php


namespace App\Repositories;

use App\Models\AccommodationLocation;
use Illuminate\Support\Facades\DB;

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
