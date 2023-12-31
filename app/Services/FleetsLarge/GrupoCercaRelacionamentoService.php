<?php


namespace App\Services\FleetsLarge;

use App\Repositories\FleetsLarge\CercasRepository;
use App\Repositories\FleetsLarge\SantanderRepository;

class GrupoCercaRelacionamentoService
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
    public function getPlaceGroupAll($gruposRelacionamento){
        $placas = array();
        foreach($gruposRelacionamento as $grupoRelacionamento){
            $santanderAll = $this->santander->findByChassi($grupoRelacionamento->chassis);

            $placas[] = $santanderAll->placa;
        }
        return $placas;
    }

    public function saveCercaGrupo($id, $id_grupo, $data){
        $this->cerca->saveCercaGrupo($id, $id_grupo, $data);
    }

}
