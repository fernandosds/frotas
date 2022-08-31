<?php


namespace App\Services;

use Illuminate\Support\Carbon;
use stdClass;
// use Illuminate\Support\Facades\Auth;
use App\Services\FleetsLarge\GrupoCercaService;
use App\Repositories\FleetsLarge\CercasRepository;


class ApiFleetLargeSantanderService
{
    public function __construct(GrupoCercaService $grupocercaService, CercasRepository $cercasRepository)
    {
        $this->grupocercaService = $grupocercaService;
        $this->cerca = $cercasRepository;
    }
    public function allGrupoSantander()
    {
        $allGrupo = $this->cerca->getAllGrupoCercaSantander();
        $geojson = new stdClass();
        $geojson->type = "FeatureCollection";
        $geojson->features = [];

        $items = json_decode($allGrupo);

        foreach ($items as $item) {
            // echo $item->santander->lp_ignicao . PHP_EOL;

            $feature = new stdClass();
            $feature->type = "Feature";
            $feature->properties = new stdClass();
            $feature->properties->id = $item->santander->modelo;
            $feature->properties->ignicao = $item->santander->lp_ignicao == '1' ? 'ON' : 'OFF';
            $feature->properties->chassis = $item->santander->chassis ?? "";
            $feature->properties->modelo_veiculo = $item->santander->modelo_veiculo ?? "";
            $feature->properties->placa = $item->santander->placa ?? "";
            $feature->properties->lp_velocidade = $item->santander->lp_velocidade ?? 0;
            $feature->properties->status_veiculo = $item->santander->status_veiculo ?? "";
            $feature->properties->filial = $item->santander->filial ?? "";
            $feature->properties->id_grupo = $item->grupo_id ?? "";
            $feature->properties->nome_grupo = $item->grupo_cerca->nome ?? "";


            $geometry = new stdClass();
            $geometry->type = "Point";
            $geometry->coordinates = [(float)$item->santander->lp_longitude, (float) $item->santander->lp_latitude];
            $feature->geometry = $geometry;

            $geojson->features[] = $feature;
        }
        return $geojson;
    }

    public function groupSelected($collectionObject){

        $allGrupo = $collectionObject;
        $geojson = new stdClass();
        $geojson->type = "FeatureCollection";
        $geojson->features = [];

        $items = json_decode($allGrupo);

        foreach ($items as $item) {
            // dd($item);
            $feature = new stdClass();
            $feature->type = "Feature";
            $feature->properties = new stdClass();
            $feature->properties->id = $item->santander->modelo ?? "";
            $feature->properties->ignicao = $item->santander->lp_ignicao == '1' ? 'ON' : 'OFF';
            $feature->properties->chassis = $item->santander->chassis ?? "";
            $feature->properties->modelo_veiculo = $item->santander->modelo_veiculo ?? "";
            $feature->properties->placa = $item->santander->placa ?? "";
            $feature->properties->lp_velocidade = $item->santander->lp_velocidade ?? 0;
            $feature->properties->status_veiculo = $item->santander->status_veiculo ?? "";
            $feature->properties->filial = $item->santander->filial ?? "";
            $feature->properties->id_grupo = $item->grupo_id ?? "";
            $feature->properties->nome_grupo = $item->grupo_cerca->nome ?? "";

            $geometry = new stdClass();
            $geometry->type = "Point";
            $geometry->coordinates = [(float)$item->santander->lp_longitude, (float) $item->santander->lp_latitude];
            $feature->geometry = $geometry;

            $geojson->features[] = $feature;
        }

        return $geojson;
    }
}
