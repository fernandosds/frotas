<?php


namespace App\Services\FleetsLarge;

use App\Repositories\FleetsLarge\PsaRepository;

class PsaService
{
    public function __construct(PsaRepository $psa)
    {
        $this->psa = $psa;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $cars = $this->psa->all();

        $aguardando_instalacao = ["REAGENDAMENTO", "OS ABERTA DE INSTALAçãO", "VEICULO INDISPONIVEL", ""];
        $instalado = ["INSTALADO", "OS ABERTA DE RETIRADA", "RETIRADO"];

        foreach ($cars as $car) {
            $car->placa_mercosul = fixPlate($car->placa);
            $car->periodo = explode(" ",  $car->data_instalacao);
            $car->data_inst = $car->periodo[0];
            $car->hora_inst = $car->periodo[1];

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
