<?php


namespace App\Services;

use App\Repositories\ContractDeviceRepository;
use App\Repositories\ContractRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ContractService
{

    /**
     * ContractService constructor.
     * @param ContractRepository $contract
     * @param ContractDeviceRepository $contract_devices
     */
    public function __construct(ContractRepository $contract, ContractDeviceRepository $contract_devices)
    {
        $this->contract = $contract;
        $this->contract_devices = $contract_devices;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->contract->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {

        return $this->contract->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {

        // $dados = $request->all();
        $dados = $request->all();

        return $this->contract->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {

        $request->merge(['uniqid' => md5(uniqid("_sat_"))]);

        $contract = $this->contract->create($request->input());
        
        if($contract){

            $arr_devices = $request->session()->get('devices');

            $arr_insert = [];
            foreach( $request->session()->get('devices') as $device ){

                $arr_insert[] = [
                    'technologie_id' =>  $device['technologie_id'],
                    'contract_id' => $contract->id,
                    'quantity' => $device['quantity'],
                    'total' => $device['total']
                ];
            }

            DB::table('contract_devices')->insert($arr_insert);

        }

        return $contract;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {

        $contract = $this->contract->update($id, ['status' => 1]);

        return $contract;
    }

    /**
     * @param Int $id
     */
    public function show(Int $id)
    {

        $contract =  $this->contract->show($id);

        return ($contract) ? $contract : abort(404);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Support\Collection|void
     */
    public function showid(Int $id)
    {

        $contract =  $this->contract->showid($id);

        return ($contract) ? $contract : abort(404);
    }

    /**
     * @param Int $id
     * @return bool
     */
    public function destroy(Int $id)
    {

        $delete = $this->contract->delete($id);
        if( $delete ){
            $this->contract_devices->deleteByContractId($id);
        }

        return $delete;
    }

    public function edit($id)
    {
        return $this->contract->find($id);
    }
}
