<?php


namespace App\Services;

use Illuminate\Support\Collection;
use stdClass;


class FleetLargeSantanderService extends ApiFleetLargeService
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
        return $this->relationshipEventWithCar(collect($events), collect($cars));
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

}
