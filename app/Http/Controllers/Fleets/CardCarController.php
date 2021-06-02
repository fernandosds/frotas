<?php

namespace App\Http\Controllers\Fleets;

use App\Services\Fleets\CardCarService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CardCarController extends Controller
{

    private $cardCarService;

    /**
     * UserController constructor.
     * @param CardCarService $cardCarService
     *
     *
     */
    public function __construct(CardCarService $cardCarService)
    {
        $this->cardCarService = $cardCarService;

    }

    /**
     * @param Int $car_id
     * @param Int $card_id
     * @return mixed
     */
    public function removeCar(Int $car_id, Int $card_id)
    {

        return $this->cardCarService->removeCar($car_id, $card_id);

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function addCards(Request $request)
    {

        return $this->cardCarService->addCards($request->input());

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function addCars(Request $request)
    {

        return $this->cardCarService->addCars($request->input());

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateStatus(Request $request)
    {
        return $this->cardCarService->updateStatus($request->devices);
    }
}
