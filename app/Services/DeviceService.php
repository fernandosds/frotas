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
    public function save(Array $array)
    {

        $arr_insert = [];
        foreach( $array[0] as $item ){

            if( $this->device->exists(trim($item[0])) == 0 ){

                if( $item[0] != "" && (int)$item[1] > 0 ){
                    $arr_insert[] = [
                        'model' => trim($item[0]),
                        'technologie_id' => (int)$item[1],
                        'uniqid' => md5(uniqid(""))
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

        try{
            $data = DB::table('devices')
                ->join('contracts', 'contracts.id', '=', 'devices.contract_id')
                ->join('technologies', 'technologies.id', '=', 'devices.technologie_id')
                ->select('devices.id', 'devices.contract_id AS contract_id', 'contracts.status','devices.model', 'devices.technologie_id', 'technologies.type AS technologie')
                ->where('contracts.status', 1)
                ->where('devices.model', $device)
                ->where('devices.customer_id', Auth::user()->customer_id)
                ->first();

            if($data){

                return ['status' => 'success', 'message' => '', 'data' => $data];

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

    /**
     * @param $id
     * @return mixed
     */
    public function filter($customer_id)
    {     
        return $this->device->filter($customer_id);
    }

    
}
