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
    /**
    public function findContractDevice(int $id)
    {
        
        $contractDevice = DB::table('contracts')
        ->join('contract_devices', 'contracts.id', '=', 'contract_devices.contract_id')
        ->join('technologies', 'contract_devices.technologie_id', '=', 'technologies.id')
        ->select('contracts.*', 'contract_devices.*', 'technologies.*')
        ->where('contracts.id', '=', $id)
        ->get();

           // print_r($contractDevice);
           // die();
        
        return $contractDevice;
    }
     */
}
