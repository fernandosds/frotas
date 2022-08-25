<?php


namespace App\Repositories;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeviceRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Device $model
     */
    public function __construct(Device $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $customer_id
     * @return \Illuminate\Support\Collection
     */
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

    /**
     * @param String $model
     * @return mixed
     */
    public function exists(String $model)
    {
        return $this->model->where('model', $model)->count();
    }

    /**
     * @param String $uniqid
     * @param Int $id
     * @return mixed
     */
    public function findByUniqid(String $uniqid)
    {
        return $this->model->where('uniqid', $uniqid)
            ->where('customer_id', Auth::user()->customer_id)
            ->first();
    }

    /**
     * @param Int $id
     * @return mixed
     */
    public function available(Int $id)
    {
        return $this->model->where('id', $id)
            ->whereNull('contract_id')
            ->whereNull('customer_id')
            ->count();
    }

    /**
     * @param String $model
     * @return mixed
     */
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

    /**
     * @param String $device
     * @return array
     */
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

    /**
     * @param int $customer_id
     * @return \Illuminate\Support\Collection
     */
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

    /**
     * @param String $device
     * @return mixed
     */
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

    /**
     * @param int $customer_id
     * @return \Illuminate\Support\Collection
     */
    public function findDevice($device = null)
    {
        return $this->model->where('model', $device)
            ->first();
    }

    /**
     * @param int $customer_id
     * @return \Illuminate\Support\Collection
     */
    public function findDeviceid($device = null)
    {
        return $this->model->where('id', $device)
            ->first();
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
        //dd($this->model->with('customer')->where('id', $idDevice)->first());
        return $this->model->with('customer')->where('id', $idDevice)->first();
    }
    public function getTechnologie($idDevice)
    {
        //dd($idDevice, "Dentro DeviceRepository");
        //dd($this->model->with('technologie')->where('id', $idDevice)->first());
        return $this->model->with('technologie')->where('id', $idDevice)->first();
    }
}
