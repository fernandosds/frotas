<?php

namespace App\Http\Controllers\Iscas\Commercial;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use App\Services\Iscas\ContractDeviceService;
use Illuminate\Http\Request;
use App\Services\Iscas\ContractService;
use App\Services\Iscas\TechnologieService;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    private $contractService;
    private $contractDeviceService;
    private $customerService;
    private $data;
    private $technologieService;

    /**
     * ContractController constructor.
     * @param ContractService $contractService
     *  @param ContractDeviceService $contractService
     * @param CustomerService $customerService
     * @param TechnologieService $technologieService
     */
    public function __construct(ContractService $contractService, CustomerService $customerService, TechnologieService $technologieService, ContractDeviceService $contractDeviceService)
    {
        $this->contractService = $contractService;
        $this->contractDeviceService = $contractDeviceService;
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
        $data['contracts'] = $this->contractService->paginatePendentes();

        return response()->view('commercial.contract.list', $data);
    }


    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {

        $data = $this->data;
        $data['contracts'] = $this->contractService->showid($id);

        return response()->view('commercial.contract.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new(Int $id = null)
    {

        $data = $this->data;
        session()->forget('devices');

        if (isset($id)) {
            $data['customer'] = $this->customerService->show($id);
        }

        $data['technologies'] = $this->technologieService->paginate();

        return view('commercial.contract.new', $data);
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
            $contract = $this->contractService->save($request);
            saveLog(['value' => $contract->id, 'type' => 'Novo Contrato', 'local' => 'ContractController', 'funcao' => 'save']);
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
        $data['technologies'] = $this->technologieService->all();

        return view('commercial.contract.new', $data);
    }

    /**
     * @param Int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Int $id)
    {
        $this->contractService->destroy($id);

        return back()->with(['status' => 'Deleted successfully']);
    }
}
