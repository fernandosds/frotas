<?php


namespace App\Services\FleetsLarge;

use App\Repositories\FleetsLarge\SantanderRepository;

class SantanderService
{
    public function __construct(SantanderRepository $santander)
    {
        $this->santander = $santander;
    }

    /**
     * @return mixed
     */
    public function all(Int $limit = 5000)
    {
        $cars = $this->santander->table($limit);

        $aguardando_instalacao = ["REAGENDAMENTO", "OS ABERTA DE INSTALAçãO", "VEICULO INDISPONIVEL", ""];
        $instalado = ["INSTALADO", "OS ABERTA DE RETIRADA", "RETIRADO"];

        foreach ($cars as $car) {
            $car->placa_mercosul = fixPlate($car->placa);
            $car->periodo = explode(" ",  $car->data_instalacao);

            $car->data_inst = $car->periodo[0];
            $car->hora_inst = $car->periodo[1] ?? "00:00:00";

            if (in_array($car->situacao, $aguardando_instalacao)) {
                $car->status_situacao = "Aguardando_Instalacao";
            }

            if (in_array($car->situacao, $instalado)) {
                $car->status_situacao = "Instalacao_Efetuada";
            }

            if (str_contains($car->cliente, '(RENEG)')) {
                $car->projeto = 'RENEGOCIACAO';
            } else {
                $car->projeto = 'FINANCEIRA';
            }
        }
        return $cars;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function findByChassi($chassis)
    {
        $chassi = $this->psa->findByChassi($chassis);
        return $chassi;
    }
}
