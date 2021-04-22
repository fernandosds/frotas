<?php


namespace App\Repositories\Fleets;

use Illuminate\Support\Facades\Auth;
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

    /**
     * @param $used
     * @return mixed
     */
    public function getAvailableCards($used)
    {

        return $this->model->where('customer_id', Auth::user()->customer_id)
            ->whereNotIn('id', $used)
            ->get();
    }

    /**
     * @return mixed
     */
    public function addCardDriver()
    {
        $cardDriver = $this->model
            ->whereraw('NOT EXISTS (SELECT * FROM drivers WHERE cards.id = drivers.card_id)')
            ->get();
        return $cardDriver;
    }
}
