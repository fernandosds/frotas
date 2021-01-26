<?php



namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Models\ContractDevice;

class ContractDeviceRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param ContractDevice $model
     */
    public function __construct(ContractDevice $model)
    {
        $this->model = $model;
    }


    public function checkStatusContractDevice(int $id)
    {

        $checkStatus = $this->model
            ->select('status')
            ->where([
                ['status', '=', 0],
                ['contract_id', '=', $id],
            ])
            ->count();

        //var_dump($checkStatus);
        //die();


        return $checkStatus;
    }
}
