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
     * @param array $array
     * @return mixed
     */
    public function save(array $array)
    {

        $arr_insert = [];
        foreach ($array[0] as $item) {

            if ($this->device->exists(trim($item[0])) == 0) {

                if ($item[0] != "" && (int)$item[1] > 0) {
                    $arr_insert[] = [
                        'model'          => trim($item[0]),
                        'technologie_id' => (int)$item[1],
                        'uniqid'         => md5(uniqid(""))
                    ];
                }
            }
        }

        $device = DB::table('devices')->insert($arr_insert);

        return ($device) ? $arr_insert : abort(404);
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
     * @return array
     */
    public function findByModel(String $device)
    {

        return $this->device->findByModel($device);
    }

    /**
     * @param String $uniqid
     * @return mixed
     */
    public function findByUniqid(String $uniqid)
    {
        return $this->device->findByUniqid($uniqid);
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

        if ($this->device->available($id) > 0) {
            return $this->device->delete($id);
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        return $this->device->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function filter($customer_id)
    {
        return $this->device->filter($customer_id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function attachDevices(Int $id, $object)
    {
        return $this->device->attachDevices($object);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function filterByContractDevice($contract_devices)
    {
        return $this->device->filterByContractDevice($contract_devices);
    }

    /**
     * @param String $device
     * @return \Illuminate\Support\Collection
     */
    public function validDevice(String $device)
    {
        return $this->device->validDevice($device);
    }

    /**
     * @param Int $id
     * @return mixed|void
     */
    public function updateStatusDevice($device, $status)
    {
        $device =  $this->device->updateStatusDevice($device, $status);
        return $device;
    }
}
