<?php

namespace App\Http\Controllers\Iscas;

use App\Http\Controllers\Controller;
use App\Services\DeviceService;
use App\Services\Iscas\TrackerService;
use App\Repositories\LogRepository;
use App\Services\LogService;
use App\Services\Iscas\TechnologieService;
use App\Http\Requests\DeviceRequest;
use App\Http\Requests\DeviceoneRequest;
use App\Services\CustomerService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    private $deviceService;
    private $data;

    public function __construct(
        DeviceService $deviceService,
        TrackerService $trackerService,
        TechnologieService $technologieService,
        CustomerService $customerService,
        LogRepository $log,
        LogService $logService
    ) {
        $this->deviceService = $deviceService;
        $this->technologieService = $technologieService;
        $this->trackerService = $trackerService;
        $this->customerService = $customerService;
        $this->log = $log;
        $this->logService = $logService;

        $this->data = [
            'icon' => 'flaticon-placeholder-3',
            'title' => 'Dispositivos',
            'menu_open_devices' => 'kt-menu__item--open'
        ];
    }

    public function index()
    {
        $customer_id = Auth::user()->customer_id;
        $data = $this->data;
        $data['devices'] = $this->deviceService->filter($customer_id);
        $data['trackers'] = $this->trackerService->filter($customer_id);

        return response()->view('stock.list', $data);
    }

    public function new()
    {
        $data = $this->data;
        $data['technologies'] = $this->technologieService->all();
        $data['customers'] = $this->customerService->getAllCustomerDevice(); // getAllCustomerDevice
        $data['devices'] = $this->deviceService->all();

        return view('stock.new', $data);
    }

    public function edit(int $id)
    {
        $data = $this->data;
        $data['device'] = $this->deviceService->show($id);
        
        $data['technologies'] = $this->technologieService->all();
        $data['customers'] = $this->customerService->getAllCustomerDevice();

        $data['technologieRel'] = $this->deviceService->getTechnologie($id);

        return response()->view('stock.edit', $data);
    }


    public function update(Request $request)
    {
        try {
            $this->deviceService->update($request, $request->id);
            $this->logService->saveLog(strval(Auth::user()->name), 'Acessou e alterou isca ' . $request->model, 'DeviceService', 'update');

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    public function delete(Request $request)
    {
        $destroy = $this->deviceService->destroy($request->id);
        $this->logService->saveLog(strval(Auth::user()->name), 'Acessou e deletou isca ' . $request->id);

        if ($destroy) {
            return response()->json(['status' => 'success', 'message' => $destroy . ' Deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => $destroy . ' O dispositivo esta em uso por um cliente!']);
        }
    }

    public function save(DeviceRequest $request)
    {

        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 180);

        if ($request->hasFile('file')) {
            $tipo = $request['tipo'];
            $customerId = $request['select'];
            $spreadsheets = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('file')->getPathname());
            $sheet = $spreadsheets->getSheet($spreadsheets->getFirstSheetIndex());
            $data = $sheet->toArray();

            $arrExistInModel = [];
            foreach ($data as $index => $cells) {
                foreach ($cells as $i => $cell) {
                    if (!is_null($cell)) {
                        if ($i >= 2) {
                            continue;
                        } else {
                            $validaModelo = $this->deviceService->findDevice($cell) ? true : false;
                            if (!$validaModelo) {
                                $arraydata[$index][$i] = $cell;
                            }else{
                                $arrExistInModel[] = $cell;
                            }
                        }
                    }
                }
            }  
            
            $this->logService->saveLog(strval(Auth::user()->name), 'Acessou e importou planilha de isca cliente id: ' . $customerId, 'DeviceService', 'save');
            return $this->deviceService->save($arraydata, $customerId, $tipo, $arrExistInModel);           
            
        } else {
            exit('Falha ao abrir arquivo.');
        }
    }


    public function saveone(DeviceoneRequest $request)
    {
        try {
            $this->deviceService->saveone($request);
            $this->logService->saveLog(strval(Auth::user()->name), 'Acessou e criou nova isca : ' . $request->model, 'DeviceService', 'saveone');
            return response()->json(['status' => 'success', 'message' => 'Dispositivo salvo com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

}
