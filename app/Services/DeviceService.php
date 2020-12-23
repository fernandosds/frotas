<?php


namespace App\Services;

use App\Repositories\DeviceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;

class DeviceService
{
    public function __construct(DeviceRepository $device)
    {
        $this->device = $device;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->device->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->device->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $dados = $request->all();

        return $this->device->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $device = $this->device->create($request->all());

        return $device;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $device = $this->device->update($id, $request->all());

        return $device;
    }

    /**
     * @param String $device
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|string|null
     */
    public function findByModel(String $device)
    {

        try{
            $data = DB::table('devices')
                ->join('contract_devices', 'contract_devices.device_id', '=', 'devices.id')
                ->join('contracts', 'contracts.id', '=', 'contract_devices.contract_id')
                ->select('devices.id', 'contracts.id AS contract_id', 'contracts.valid','devices.model', 'contract_devices.device_type')
                ->where('devices.model', $device)
                ->where('contracts.customer_id', Auth::user()->customer_id)
                ->first();

            if($data){

                return ($data->valid == 1 ) ? ['status' => 'success', 'message' => '', 'data' => $data] : ['status' => 'error', 'message' => 'O contrato vinculado a esta ísca está vencido!'];

            }else{
                return ['status' => 'error', 'message' => 'Ísca não encontrada'];

            }

        }catch (Exception $e){

            return ['status' => 'error', 'message' => $e->getMessage(), 'data' => ''];
        }

    }

    /**
     * @param Int $id
     * @return mixed|void
     */
    public function show(Int $id)
    {

        $device =  $this->device->find($id);

        return ($device) ? $device : abort(404);
    }

    /**
     * @param Int $id
     * @return bool
     */
    public function destroy(Int $id)
    {

        return $this->device->delete($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        return $this->device->find($id);
    }
}
