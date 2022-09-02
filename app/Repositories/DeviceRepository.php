<?php


namespace App\Repositories;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeviceRepository extends AbstractRepository
{

    public function __construct(Device $model)
    {
        $this->model = $model;
    }

    public function filter(int $customer_id)
    {
        $adminSat = Auth::user()->email == 'admin@satcompany.com.br';

        $customer = $this->model
            ->when(!$adminSat, function ($query) {
                return $query->where('customer_id', Auth::user()->customer_id);
            })
            ->get();

        return $customer;
    }

    public function exists(String $model)
    {
        return $this->model->where('model', $model)->count();
    }

    public function findByUniqid(String $uniqid)
    {
        return $this->model->where('uniqid', $uniqid)
            ->where('customer_id', Auth::user()->customer_id)
            ->first();
    }

    public function available(Int $id)
    {
        return $this->model->where('id', $id)
            ->whereNull('contract_id')
            ->whereNull('customer_id')
            ->count();
    }

    public function attachDevices($object)
    {
        $devices = $this->model
            ->whereNull('contract_id')
            ->whereNull('customer_id')
            ->where('technologie_id', $object->technologie_id)
            ->limit($object->quantity);

        if ($devices->count() < $object->quantity) {
            return ['status' => 'error', 'message' => 'Quantidade de dispositivos insuficiente no estoque'];
        } else {

            $devices->update([
                'contract_id' => $object->contract_id,
                'customer_id' => $object->contract->customer_id,
                'status'      => 'disponivel',
            ]);

            return ($devices) ? ['status' => 'success'] : ['status' => 'error'];
        }
    }

    public function findByModel(String $device)
    {

        try {
            $adminSat = Auth::user()->email == 'admin@satcompany.com.br';
            $data = DB::table('devices')
                ->join('technologies', 'technologies.id', '=', 'devices.technologie_id')
                ->select('devices.uniqid', 'devices.id', 'devices.model', 'devices.technologie_id', 'technologies.type AS technologie')
                ->where('devices.model', $device)
                ->when(!$adminSat, function ($query) {
                    return $query->where('devices.customer_id', Auth::user()->customer_id);
                })
                ->first();

            if ($data) {
                return ['status' => 'success', 'message' => '', 'data' => $data];
            } else {
                return ['status' => 'error', 'message' => 'Ísca não encontrada'];
            }
        } catch (\Exception $e) {

            return ['status' => 'error', 'message' => $e->getMessage(), 'data' => ''];
        }
    }

    public function filterByContractDevice($contract_devices)
    {
        try {

            $devices = $this->model

                ->where('technologie_id', $contract_devices->technologie_id)
                ->where('contract_id', $contract_devices->contract_id)
                ->get();

            return $devices;
        } catch (\Exception $e) {

            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function validDevice(String $device)
    {

        if (Auth::user()->email == 'admin@satcompany.com.br') {
            return $this->model->where('model', $device)
                ->whereNotNull('contract_id')
                ->count();
        }

        return $this->model->where('model', $device)
            ->where('customer_id', Auth::user()->customer_id)
            ->whereNotNull('contract_id')
            ->count();
    }

    public function findDevice($device = null)
    {
        return $this->model->where('model', $device)
            ->first();
    }

    public function findDeviceid($device = null)
    {
        return $this->model->where('id', $device)->first();
    }

    public function updateStatusDevice($device, $status)
    {
        return $this->model
            ->where('model', '=', $device->model)
            ->where('customer_id', '=', Auth::user()->customer_id)
            ->update(['status' =>  $status]);
    }

    public function getCustomer($idDevice)
    {
        return $this->model->with('customer')->where('id', $idDevice)->first();
    }
    public function getTechnologie($idDevice)
    {
        return $this->model->with('technologie')->where('id', $idDevice)->first();
    }

    public function updateDevice($request){
        try{
            $findModel = $this->model->find($request->registro);
            $findModel->technologie_id = $request->technologie_id;
            $findModel->customer_id = $request->customer_id;
            if($findModel->save()){
                return response()->json(['status' => 200, 'message' => 'Alterado com sucesso!']);
            }
            return response()->json(['status' => 500, 'message' => 'Não foi possivel alterar a isca']);
        }catch(\Exception $e){
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function deleteDevice($id){
        try{
            $deleteDevice = $this->model->find($id);
            $result = ($deleteDevice->delete()) ? true : false;
            if($result){
                return response()->json(['status' => 200, 'message' => 'Excluído com sucesso!']);
            }else{
                return response()->json(['status' => 500, 'message' => 'Não foi possivel alterar a isca']);
            }
        }catch(\Exception $e){
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

}
