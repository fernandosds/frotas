<?php


namespace App\Services\FleetsLarge;

use App\Repositories\FleetsLarge\CercasRepository;
use App\Repositories\FleetsLarge\SantanderRepository;

class GrupoCercaService
{
    public function __construct(SantanderRepository $santander, CercasRepository $cerca)
    {
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
    public function getPlaceGroupAll($gruposRelacionamento)
    {
        $placas = array();
        foreach ($gruposRelacionamento as $grupoRelacionamento) {
            $santanderAll = $this->santander->findByChassi($grupoRelacionamento->chassis);

            $placas[] = $santanderAll->placa;
        }
        return $placas;
    }

    public function saveCercaGrupo($id, $id_grupo, $data)
    {
        $this->cerca->saveCercaGrupo($id, $id_grupo, $data);
    }


    public function destroy($id)
    {
        $cerca = $this->cerca->delete($id);
        return $cerca;
    }

    public function removePlates($removePlates){
        return $this->santander->removePlates($removePlates);
    }

    public function findByChassi($chassis){
        return $this->santander->findByChassi($chassis);
    }
    public function allGroup()
    {
        $grupo = $this->cerca->all();
        return $grupo;
    }

    public function getGrupoCercaSantander($arrGrupo){
        return $this->cerca->getGrupoCercaSantander($arrGrupo);
    }

    public function getAllGrupoCercaSantanderParameters($arrGrupo){
        return $this->cerca->getAllGrupoCercaSantanderParameters($arrGrupo);
    }

    public function getAllCercas($arrCercas){
        return $this->cerca->getAllCercas($arrCercas);
    }
}
