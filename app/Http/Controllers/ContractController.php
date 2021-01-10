<?php

namespace App\Http\Controllers;

//use App\Models\Technologie;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use App\Services\ContractService;
use App\Services\TechnologieService;

//use App\Services\CustomerService;
//use App\Http\Requests\ContractRequest;

class ContractController extends Controller
{
    private $contractService;
    private $customerService;
    private $data;
    private $technologieService;

    public function __construct(ContractService $contractService, CustomerService $customerService, TechnologieService $technologieService)
    {
        $this->contractService = $contractService;
        $this->customerService = $customerService;
        $this->technologieService = $technologieService;


        $this->data = [
            'icon' => 'flaticon2-contract',
            'title' => 'Contrato',
            'menu_open_contracts' => 'kt-menu__item--open'
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
        $data['contracts'] = $this->contractService->paginate();

        return response()->view('contract.list', $data);
    }




    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {

        $data = $this->data;
        $data['contracts'] = $this->contractService->showid($id);

        //print_r($data);
        //die();

        return response()->view('contract.list', $data);
    }
    /**
    public function search($cpf_cnpj)
    {

        $customer = $this->customerService->search($cpf_cnpj);

        if ($customer) {
            return response()->json(['status' => 'success', 'data' => $customer]);
        } else {
            return response()->json(['status' => 'error', 'message'=> 'usuário não encontrado!']);
        }
    }

     */

    public function search(Request $request)
    {

        $customer = $this->customerService->search($request);

        //print_r($request->cpf_cnpj);
        //print_r($request['cpf_cnpj']);
        //die();

        if ($customer) {
            return response()->json(['status' => 'success', 'data' => $customer]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'usuário não encontrado!']);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        $data['technologies'] = $this->technologieService->paginate();

        return view('contract.new', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        try {

            $this->contractService->save($request);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['contract'] = $this->contractService->show($id);

        return view('contract.new', $data);
    }

    /**
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Int $id, Request $request)
    {

        try {

            $this->contractService->update($request, $request->id);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $this->contractService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
   

    public function addDevice(Request $request)
    {
        $devices = explode(',', $request->input('new-device'));
        $tableContent='';
        foreach($devices AS $device){
            $tableContent .= "<tr><td></td><td>".$device."</td><td></td></tr>";
        }
        return $tableContent;
    }
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function addDevice(Request $request)
    {
        $devices = explode(',', $request->input('devices'));

        $technologie = $this->technologieService->show($request->technologie_id);

        // $merged = $devices->merge($technologies);

        // print_r($devices);

        $current_devices = session('devices');
        print_r($current_devices);
        die;

        $data = [];
        foreach ($devices as $device) {
            $data['devices'] = [
                'device' => $device,
                'technologie_id' => $technologie->id,
                'price' => $technologie->price,
                'type' => $technologie->type,
            ];
        }

        session(['devices' => $data['devices']]);
       

        dd($request->session()->get('devices'));
        die();

        /* ler o input
        incrementar session
         */

        return view('device.list_device', $devices);
    }
}
