<?php


namespace App\Services;

use App\Repositories\ContractRepository;
use Illuminate\Http\Request;
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
        print_r($request->all());       

        die();

        $array_contract[] = [
            'customer_id'   => $request->customer_id,
            'user_id'       => $request->user_id
        ];

        //print_r($array_contract);

        $model = $request->model;

        $arr_devices = $request->session()->get('devices');

        foreach ($arr_devices as $arr) {
            $device         = $arr['device'];
            $tecnology_id   = $arr['tecnology_id'];
            $tecnology      = $arr['tecnology'];
            $price          = $arr['price'];


            //print_r($arr['tecnology']);
        }

        


        $contract = $this->contract->create($request->all());

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
