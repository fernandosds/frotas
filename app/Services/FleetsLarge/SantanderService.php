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
    // public function all($limit = 25000)
    public function all($limit = 35000)
    {
        $cars = $this->santander->table($limit);

        $aguardando_instalacao = ["REAGENDAMENTO", "OS ABERTA DE INSTALAçãO", "VEICULO INDISPONIVEL", ""];
        $instalado = ["INSTALADO", "OS ABERTA DE RETIRADA", "RETIRADO"];
        $today = date("Y-m-d H:i:s");

        foreach ($cars as $car) {

            $car->dt_tecnico_acionado = ($car->dt_tecnico_acionado == "") ? $today : $car->dt_tecnico_acionado;
            $car->dt_termino_instalacao = ($car->dt_termino_instalacao == "") ? $today : $car->dt_termino_instalacao;
            $car->dt_inicio_instalacao = ($car->dt_inicio_instalacao == "") ? $today : $car->dt_inicio_instalacao;

            $car->placa_mercosul = fixPlate($car->placa);
            $car->periodo = explode(" ",  $car->data_instalacao);

            $car->data_inst = $car->periodo[0];
            $car->hora_inst = $car->periodo[1] ?? "00:00:00";




            if ($car->event_violacao == "true" && $car->event_encerrado == '0') {
                $car->event_violacao = "bateria_violada";
            } else {
                $car->event_violacao = "bateria_nao_violada";
            }



            if ($car->manutencao == "true") {
                $car->manutencao = "equipamento_manutencao";
            }


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
