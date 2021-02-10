<?php


namespace App\Repositories\Rent;

use Illuminate\Support\Facades\DB;
use App\Models\Card;
use App\Repositories\AbstractRepository;

class CardRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Card $model
     */
    public function __construct(Card $model)
    {
        $this->model = $model;
    }
}
