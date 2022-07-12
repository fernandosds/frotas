<?php


namespace App\Services\FleetsLarge;

use App\Repositories\FleetsLarge\UsuariosRepository;
use App\Repositories\FleetsLarge\SantanderRepository;

class GrupoUsuariosService
{
    public function __construct(SantanderRepository $santander, UsuariosRepository $grupoUsuario)
    {
        // $this->cerca = $cerca;
        $this->santander = $santander;
        $this->grupoUsuario = $grupoUsuario;
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

    public function saveGrupoUsuario($id, $data){
        $this->grupoUsuario->saveGrupoUsuario($id, $data);
    }

    public function destroy($id)
    {
        $cerca = $this->grupoUsuario->delete($id);
        return $cerca;
    }
}
