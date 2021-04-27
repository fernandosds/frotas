<?php

/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 13/04/2021
 * Time: 11:25
 */

namespace App\Services\Fleets;


use App\Repositories\Fleets\CardCarRepository;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Print_;

class CardCarService
{

    /**
     * @var CardCarRepository
     */
    protected $driverCardCarRepository;

    /**
     * DriverCardCarService constructor.
     * @param CardCarRepository $cardCarRepository
     */
    public function __construct(CardCarRepository $cardCarRepository)
    {
        $this->cardCarRepository = $cardCarRepository;
    }

    /**
     * @param Int $id
     * @return mixed
     */
    public function getCarsByCardId(Int $id)
    {
        return $this->cardCarRepository->getCarsByCardId($id);
    }

    /**
     * @param Int $id
     * @return mixed
     */
    public function getCardByCarId(Int $id)
    {
        return $this->cardCarRepository->getCardByCarId($id);
    }

    /**
     * @param Int $car_id
     * @param Int $card_id
     * @return mixed
     */
    public function removeCar(Int $car_id, Int $card_id)
    {
        return $this->cardCarRepository->removeCar($car_id, $card_id);
    }

    /**
     * @param array $data
     */
    public function addCards(array $data)
    {
        $user_id = Auth::user()->id;
        $customer_id = Auth::user()->customer_id;
        $date = date('Y-m-d H:i:s');

        foreach ($data['cards'] as $card) {
            $attach[] = array(
                'card_id' => $card,
                'car_id' => $data['car_id'],
                'customer_id' => $customer_id,
                'user_id' => $user_id,
                'created_at' => $date
            );
        }

        return $this->cardCarRepository->addCards($attach);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addCars(array $data)
    {
        $user_id = Auth::user()->id;
        $customer_id = Auth::user()->customer_id;
        $date = date('Y-m-d H:i:s');

        foreach ($data['cars'] as $car) {
            $attach[] = array(
                'card_id' => $data['card_id'],
                'car_id' => $car,
                'customer_id' => $customer_id,
                'user_id' => $user_id,
                'created_at' => $date
            );
        }
        return $this->cardCarRepository->addCards($attach);
    }
}
