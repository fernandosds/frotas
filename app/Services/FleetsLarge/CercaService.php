<?php


namespace App\Services\FleetsLarge;

use App\Repositories\FleetsLarge\CercaRepository;
use App\Repositories\FleetsLarge\SantanderRepository;

class CercaService
{
    public function __construct(SantanderRepository $santander/*CercaRepository $cerca*/)
    {
        // $this->cerca = $cerca;
        $this->santander = $santander;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $cars = $this->santander->all();
        return $cars;
    }

     /**
     * @return mixed
     */
    public function getPlate()
    {
        $cars = $this->santander->getPlate();
        return $cars;
    }
}
