<?php


namespace App\Services\FleetsLarge;

use App\Repositories\FleetsLarge\CercasRepository;
use App\Repositories\FleetsLarge\SantanderRepository;

class GrupoCercaService
{
    public function __construct(SantanderRepository $santander, CercasRepository $cerca)
    {
        // $this->cerca = $cerca;
        $this->santander = $santander;
        $this->cerca     = $cerca;
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

    public function saveCercaGrupo($id, $data){
        $this->cerca->saveCercaGrupo($id, $data);
    }
}
