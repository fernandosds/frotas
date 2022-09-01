<?php

namespace App\Http\Controllers\Iscas\Production;

use App\Http\Controllers\Controller;
use App\Services\LogService;
use App\Repositories\LogRepository;
//use App\Imports\DeviceImport;
//use App\Imports\DeviceImportTracker;
use App\Services\Iscas\TechnologieService;
use App\Http\Requests\DeviceRequest;
use App\Http\Requests\DeviceoneRequest;
use App\Services\DeviceService;
use App\Services\CustomerService;
use App\Services\Iscas\TrackerService;
use App\Models\Customer;
use App\Models\Technologie;
//use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    private $deviceService;
    private $trackerService;
    private $technologieService;
    private $data;
    private $customerService;
    private $contractService;
    private $logService;


    /**
     * DeviceController constructor.
     * @param DeviceService $deviceService
     * @param TechnologieService $technologieService
     * @var LogService
     */
    public function __construct(
        DeviceService $deviceService,
        TechnologieService $technologieService,
        TrackerService $trackerService,
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
            'title' => 'Produtos',
            'menu_open_devices' => 'kt-menu__item--open'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->data;
        $data['devices'] = $this->deviceService->all();
        //$data['devices'] = $this->deviceService->paginate();

        return response()->view('production.device.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        $data['technologies'] = $this->technologieService->all();
        $data['customers'] = $this->customerService->getAllCustomerDevice(); // getAllCustomerDevice
        $data['devices'] = $this->deviceService->all();

        //dd($data['customers']);

        return view('production.device.new', $data);
    }

    /**
     * @param DeviceoneRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveone(DeviceoneRequest $request)
    {

        $this->deviceService->saveone($request);
        $this->logService->saveLog(strval(Auth::user()->name), 'Acessou e criou nova isca : ' . $request->model, 'DeviceService', 'saveone');

        try {
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param DeviceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(DeviceRequest $request)
    {

        //dd($request['tipo']);

        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 180); //3 minutes

        if ($request->hasFile('file')) {
            $tipo = $request['tipo'];
            $customerId = $request['select'];

            $spreadsheets = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('file')->getPathname());
            $sheet = $spreadsheets->getSheet($spreadsheets->getFirstSheetIndex());
            $data = $sheet->toArray();

            foreach ($data as $index => $cells) {
                foreach ($cells as $i => $cell) {
                    if (!is_null($cell)) {
                        if ($i >= 2) {
                            continue;
                        } else {
                            //dd($cell);
                            $validaModelo = $this->deviceService->findDevice($cell);
                            if (!$validaModelo) {
                                //dd($validaModelo);
                                $arraydata[$index][$i] = (string)$cell;
                            }
                        }
                    }
                }
            }

            //dd($arraydata, $customerId, $tipo);

            $inserts = $this->deviceService->save($arraydata, $customerId, $tipo);
            $this->logService->saveLog(strval(Auth::user()->name), 'Acessou e importou planilha de isca cliente id: ' . $customerId, 'DeviceService', 'save');

            return response()->json([
                'status' => 'success',
                'message' => count($inserts)
            ], 200);
        } else {
            exit('Falha ao abrir arquivo.');
            //dd("não entrou");
        }
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
 
        $data = $this->data;
        $data['device'] = $this->deviceService->show($id);
        
        $data['technologies'] = $this->technologieService->all();
        $data['customers'] = $this->customerService->getAllCustomerDevice();

        //var_dump($data['device']); die();

        //dd(Technologie::with('devices'));die();
        //$data['deviceRel'] = $this->deviceService->getCustomer($id);
        //$data['devices'] = $this->deviceService->all($id);

        $data['technologieRel'] = $this->deviceService->getTechnologie($id);
        // getAllCustomerDevice

        //dd($data['technologieRel']);
        return view('production.device.edit', $data);
    }

    /**
     * @param Int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {

        $destroy = $this->deviceService->destroy($id);
        $this->logService->saveLog(strval(Auth::user()->name), 'Acessou e deletou a isca id' . $id, 'DeviceService', 'destroy');

        if ($destroy) {
            return back()->with(['status' => 'Deleted successfully']);
        } else {
            return back()->with(['status' => 'O dispositivo esta em uso por um cliente!']);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        // $data = $this->data;
        // $data['devices'] = $this->deviceService->paginate();

        // return response()->view('production.device.list', $data);

        $destroy = $this->deviceService->destroy($id);
        $this->logService->saveLog(strval(Auth::user()->name), 'Acessou e deletou isca ' . $id);

        if ($destroy) {
            return response()->json(['status' => 'success', 'message' => $destroy . ' Deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => $destroy . ' O dispositivo esta em uso por um cliente!']);
        }
    }
}
