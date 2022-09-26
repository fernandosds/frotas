<?php


namespace App\Services;

use App\Repositories\DeviceRepository;
use App\Repositories\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;
use Carbon\Carbon;


class DeviceService
{
    public function __construct(DeviceRepository $deviceRepository, LogRepository $log)
    {
        $this->deviceRepository = $deviceRepository;
        $this->log = $log;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->deviceRepository->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->deviceRepository->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $dados = $request->all();

        return $this->deviceRepository->create($dados)->orderBy('id')->get();
    }

    /**
     * @param array $array
     * @return mixed
     */
    public function saveone(Request $request)
    {

        if ($this->deviceRepository->exists($request->model)) {

            return abort(500);

        } else {
            if(!strlen($request->model) == 8)
                return response()->json(['status' => 'internal_error', 'errors' => "Quantidade de caracters do modelo, menor/maior que 8"], 400);
            $arr_insert[] = [
                'model'          => trim(strtoupper($request->model)),
                'technologie_id' => (int)$request->technologie_id,
                'customer_id'    => (int)$request->customer_id,
                'tipo'           => trim($request->tipo),
                'uniqid'         => md5(uniqid("")),
                'status'         => 'disponivel',
                'created_at'     => Carbon::now(),
            ];

            $device = DB::table('devices')->insert($arr_insert);

            saveLog(['value' => $request['model'], 'type' => 'Acessou e Criou nova Isca', 'local' => 'DeviceService', 'funcao' => 'saveone']);
            return $device;

        }

    }

    /**
     * @param array $array
     * @return mixed
     */
    public function save(array $array, $customer, $tipo, $arrExistInModel)
    {
        $arr_insert = [];
        $arr_bad_format = [];


        foreach ($array as $index => $item) {
            if(isset($item[0])){
                if(strlen($item[0]) > 8){
                    $arr_bad_format[$index] = $item[0];
                }else{
                    if(isset($item[0])){
                        $arr_insert[] = [
                        'model'          => trim(strtoupper($item[0])),
                        'technologie_id' => (int)$item[1],
                        'customer_id'    => (int)$customer,
                        'tipo'           => trim($tipo),
                        'uniqid'         => md5(uniqid("")),
                        'status'         => 'disponivel',
                        'created_at'     => Carbon::now(),
                        ];
                    }
                }
            }else{
                continue;
                //return response()->json(['status' => 'error', 'message' => 'Models já existem ou estão errados'], 200);
            }
        }

        $device = DB::table('devices')->insert($arr_insert);
        
        //MOSTRA OS MODELOS QUE JÁ ESTÃO CADASTRADAS
        // if(!empty($arrExistInModel)){
        //     $message = "Modelo(s) não cadastrado(s)  porque já existe os Modelo(s): ";
        //     foreach($arrExistInModel as $existModel){
        //         $message .= $existModel .', ';
        //     };
        //     $format_message = substr($message, 0, -2);

        //     return response()->json(['status' => 'error', 'message' => $format_message], 200);
        // }
        if(!empty($arr_bad_format)){
            $message = '';
            $message .= "Números de dispositivos errados: |";
            
            foreach($arr_bad_format as $index => $format){
                $num_linha = $index + 1;
                $message .= "LINHA {$num_linha} - " . strtoupper($format) . "|";
            }

            return response()->json(['status' => 'error', 'message' => $message], 200);
            
        }
        
        return ($device) ?  response()->json(['status' => 'success', 'message' => "Inserido com sucesso!"], 200) : response()->json(['status' => 'error', 'message' => "Não foi possivel salvar. tente novamente mais tarde."], 200);

    }

    public function update(Request $request)
    {
        $device = $this->deviceRepository->updateDevice($request);
        return $device;
    }

    /**
     * @param String $device
     * @return array
     */
    public function findByModel(String $device)
    {
        return $this->deviceRepository->findByModel($device);
    }

     /**
     * @param String $device
     * @return array
     */
    public function findDevice(String $device)
    {
        return $this->deviceRepository->findDevice($device);
    }

    /**
     * @param String $uniqid
     * @return mixed
     */
    public function findByUniqid(String $uniqid)
    {
        return $this->deviceRepository->findByUniqid($uniqid);
    }

    /**
     * @param Int $id
     * @return mixed|void
     */
    public function show(Int $id)
    {
        $device =  $this->deviceRepository->find($id);
        return ($device) ? $device : abort(404);
    }

    /**
     * @param Int $id
     * @return bool
     */
    public function destroy(Int $id)
    {
        return $this->deviceRepository->deleteDevice($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        return $this->deviceRepository->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function filter($customer_id)
    {
        return $this->deviceRepository->filter($customer_id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function attachDevices(Int $id, $object)
    {
        return $this->deviceRepository->attachDevices($object);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function filterByContractDevice($contract_devices)
    {
        return $this->deviceRepository->filterByContractDevice($contract_devices);
    }

    /**
     * @param String $device
     * @return \Illuminate\Support\Collection
     */
    public function validDevice(String $device)
    {
        return $this->deviceRepository->validDevice($device);
    }

    /**
     * @param Int $id
     * @return mixed|void
     */
    public function updateStatusDevice($device, $status)
    {
        $device =  $this->deviceRepository->updateStatusDevice($device, $status);
        return $device;
    }

    public function getCustomer($idDevice){
        return $this->deviceRepository->getCustomer($idDevice);
    }
    public function getTechnologie($idDevice){
        return $this->deviceRepository->getTechnologie($idDevice);
    }

}
