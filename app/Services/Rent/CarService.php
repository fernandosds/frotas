<?php


namespace App\Services\Rent;

use App\Repositories\Rent\CarRepository;


class CarService
{
    public function __construct(CarRepository $car)
    {
        $this->car = $car;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->car->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->car->paginate($limit);
    }
}
