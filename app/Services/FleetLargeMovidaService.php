<?php


namespace App\Services;

use Illuminate\Support\Collection;
use stdClass;


class FleetLargeMovidaService extends ApiFleetLargeService
{


    public function allCars($hash)
    {
        $data = $this->carsDetails($hash);
        return $data;
    }

    private function carsDetails($hash)
    {
        $cars = $this->getByHash($hash);
        $events = $this->getByHash('c58de3ae-f519-4ec6-bd87-4e011c1cb2ea');
        return $this->relationshipEventWithCar(collect($events), collect($cars)->toArray());
    }

    private function relationshipEventWithCar(Collection $events,  $cars)
    {
        $newCars = [];
        foreach ($cars as $car) {
            $car['event'] = [];
            if ($events->firstWhere('placa_veiculo', $car['placa'])) {
                $car['event'] = $events->firstWhere('placa_veiculo', $car['placa']);
            }
            $newCars[] = $car;
        }

        return $newCars;
    }


    private function getByHash($hash)
    {
        $url = $this->host . "/" . $hash . ".json";
        return ClientHttp($url);
    }

    /**
     * @param String $device
     * @param Int $minutes
     * @return array
     */
    public function getGridModel(String $dateStart, String $dateEnd, String $device)
    {
        /**
         * Exemplo URL: https://api.satcompany.com.br/movida_positions/?start=2021-08-01&end=2021-08-20&id=99372114
         */
        $url = $this->host_apis . "movida_positions/?start={$dateStart}&end={$dateEnd}&id={$device}";
        return ClientHttp($url);
    }
}
