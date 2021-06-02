<?php

/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 13/04/2021
 * Time: 11:13
 */

namespace App\Repositories\Fleets;


use App\Models\CardCar;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CardCarRepository extends AbstractRepository
{

    /**
     * DriverCardCarRepository constructor.
     * @param CardCar $model
     * 
     *
     */
    public function __construct(CardCar $model)
    {
        $this->model = $model;
    }

    /**
     * @param Int $id
     * @return mixed
     */
    public function getCarsByCardId(Int $id = null)
    {
        return $this->model->where('customer_id', Auth::user()->customer_id)
            ->where('card_id', $id)
            ->get();
    }

    /**
     * @param Int $id
     * @return mixed
     */
    public function getCardByCarId(Int $id)
    {
        return $this->model->where('customer_id', Auth::user()->customer_id)
            ->where('car_id', $id)
            ->get();
    }

    /**
     * @param Int $car_id
     * @return mixed
     */
    public function usedCards(Int $car_id)
    {
        return $this->model->where('customer_id', Auth::user()->customer_id)
            ->where('car_id', $car_id)
            ->get();
    }

    /**
     * @param Int $car_id
     * @return mixed
     */
    public function usedCars(Int $card_id = null)
    {
        return $this->model->where('customer_id', Auth::user()->customer_id)
            ->where('card_id', $card_id)
            ->get();
    }

    /**
     * @param Int $car_id
     * @param Int $card_id
     * @return mixed
     */
    public function removeCar(Int $car_id, Int $card_id)
    {
        return $this->model->where('customer_id', Auth::user()->customer_id)
            ->where('car_id', $car_id)
            ->where('card_id', $card_id)
            ->delete();
    }

    /**
     * @param array $attach
     */
    public function addCards(array $attach)
    {

        DB::table('card_car')->insert($attach);
    }

    /**
     * @param String $token
     * @param String $type_command
     * @param String $status
     * @return mixed
     */
    public function updateStatus(String $token, String $type_command, String $status)
    {

        $command = $this->model->where('token', $token)->first();

        if( $status == "Sucesso" && $type_command == "detach" ){
            return $command->delete();
        }else{
            $command->status = $status;
            return $command->save();
        }

    }

    /**
     * @param array $attacments
     * @return mixed
     */
    public function getToken(Array $attacments)
    {
       return $this->model->whereIn('id', $attacments)->get();
    }

    /**
     * @param Int $car_id
     * @param Int $card_id
     * @param String $token
     * @return mixed
     */
    public function setToken(Int $car_id, Int $card_id, String $token)
    {
        $command = $this->model->where('car_id', $car_id)->where('card_id', $card_id)->first();
        $command->token = $token;
        return $command->update();
    }
}
