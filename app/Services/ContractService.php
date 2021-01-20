<?php


namespace App\Services;

use App\Repositories\ContractRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ContractService
{
    public function __construct(ContractRepository $contract)
    {
        $this->contract = $contract;
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

        $contract = $this->contract->create($request->input());
        
        if($contract){

            $arr_devices = $request->session()->get('devices');

            $arr_insert = [];
            foreach( $request->session()->get('devices') as $device ){

                //  [quantity] => 10 [technologie_id] => 1 [value] => 2 [total] => 20 ) )
                $arr_insert[] = [
                    'technologie_id' => $device['technologie_id'],
                    'contract_id' => $contract->id,
                    'quantity' => $device['quantity'],
                    'total' => $device['total']
                ];
            }

            DB::table('contract_devices')->insert($arr_insert);

        }


/**
       
        $model = $request->model;

        $arr_devices = $request->session()->get('devices');

        foreach ($arr_devices as $arr) {
            $device         = $arr['device'];
            $technologie_id   = $arr['technologie_id'];
            $technologie      = $arr['technologie'];
            $price          = $arr['price'];


            //print_r($arr['technologie']);
        }


        //$contract = $this->contract->create($request->all());

         */

        return $contract;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {


        $contract = $this->contract->update($id, $request->all());
        return $contract;
    }

    public function show(Int $id)
    {

        $contract =  $this->contract->show($id);

        return ($contract) ? $contract : abort(404);
    }

    public function showid(Int $id)
    {

        $contract =  $this->contract->showid($id);

        return ($contract) ? $contract : abort(404);
    }


    /**
     * @param Int $id
     */
    public function destroy(Int $id)
    {

        return $this->contract->delete($id);
    }

    public function edit($id)
    {
        return $this->contract->find($id);
    }
}
