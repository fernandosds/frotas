<?php

/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 13/04/2021
 * Time: 11:25
 */

namespace App\Services\Fleets;


use App\Repositories\Fleets\CardCarRepository;
use App\Repositories\Fleets\CardRepository;
use App\Repositories\Fleets\CarRepository;
use App\Services\CommandService;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Print_;

class CardCarService
{

    /**
     * @var
     */
    protected $driverCardCarRepository;
    protected $commandService;
    protected $carRepository;
    protected $cardRepository;

    /**
     * CardCarService constructor.
     * @param CardCarRepository $cardCarRepository
     * @param CommandService $commandService
     * @param CarRepository $carRepository
     * @param CardRepository $cardRepository
     *
     */
    public function __construct(
        CardCarRepository $cardCarRepository,
        CommandService $commandService,
        CarRepository $carRepository,
        CardRepository $cardRepository
    )
    {
        $this->cardCarRepository = $cardCarRepository;
        $this->commandService = $commandService;
        $this->carRepository = $carRepository;
        $this->cardRepository = $cardRepository;
    }

    /**
     * @param Int $id
     * @return mixed
     */
    public function getCarsByCardId(Int $id = null)
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

        // SendCommand
        $token = $this->commandService->removeCartToDevice($car_id,$card_id);

        // SetToken
        $this->setToken($car_id,$card_id, $token);

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
        $attach = [];

        foreach( $data['cards'] as $card_id ) {

            // SendCommand
            $car = $this->carRepository->show($data['car_id']);
            $card = $this->cardRepository->show($card_id);
            $token = $this->commandService->addCardToDevice($card->serial_number, $car->device);

            if (isset($token)) {
                $attach[] = array(
                    'card_id' => $card_id,
                    'car_id' => $data['car_id'],
                    'customer_id' => $customer_id,
                    'user_id' => $user_id,
                    'created_at' => $date,
                    'token' => $token,
                    'status' => 'new',
                    'type_command' => 'attach'
                );
            }
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
        $attach = [];

        foreach( $data['cars'] as $car_id ){

            // SendCommand
            $car = $this->carRepository->show($car_id);
            $card = $this->cardRepository->show($data['card_id']);
            $token = $this->commandService->addCardToDevice($card->serial_number,$car->device);

            if(isset($token)){
                $attach[] = array(
                    'card_id' => $data['card_id'],
                    'car_id' => $car_id,
                    'customer_id' => $customer_id,
                    'user_id' => $user_id,
                    'created_at' => $date,
                    'token' => $token,
                    'status' => 'Iniciado',
                    'type_command' => 'detach'
                );
            }

        }
        return $this->cardCarRepository->addCards($attach);
    }

    /**
     * @param array $attacments
     * @return mixed|string
     */
    public function updateStatus(Array $attacments)
    {

        $tokens = $this->cardCarRepository->getToken($attacments);

        foreach($tokens as $token){
            $data = $this->commandService->checkStatus($token->token);
            if($data['status'] == "sucesso"){
                $this->cardCarRepository->updateStatus($token->token, $token->type_command, $data['body'][0]['Estado']);
            }
        }

        return 'true';

    }

    /**
     * @param Int $car_id
     * @param Int $card_id
     */
    public function setToken(Int $car_id, Int $card_id, String $token)
    {
        $data = $this->cardCarRepository->setToken($car_id, $card_id, $token);
    }

}
