<?php



namespace App\Repositories\Iscas;

use Illuminate\Support\Facades\DB;

use App\Models\ContractDevice;
use App\Repositories\AbstractRepository;

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
                ['status', '=', null],
                ['contract_id', '=', $id],
            ])
            ->count();

        return $checkStatus;
    }

}
