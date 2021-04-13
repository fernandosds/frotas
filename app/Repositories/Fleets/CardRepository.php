<?php


namespace App\Repositories\Fleets;

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

    public function addCardDriver()
    {
        $cardDriver = $this->model
            ->whereraw('serial_number NOT IN (SELECT card_number FROM drivers)')
            ->get();
        return $cardDriver;
    }
}
