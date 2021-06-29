<?php

namespace App\Repositories\Iscas;


use App\Models\Tracker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\AbstractRepository;

class TrackerRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Boarding $model
     */
    public function __construct(Tracker $model)
    {
        $this->model = $model;
    }

    public function findTrackerByModel($trackerModel)
    {
        $trackerModel = $this->model
            ->where('model', '=', $trackerModel)
            ->where('customer_id', '=', Auth::user()->customer_id)
            ->first();

        return $trackerModel;
    }
}
