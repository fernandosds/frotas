<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContractService;
use App\Services\ContractDeviceService;
use Illuminate\Support\Facades\Auth;

class LogisticController extends Controller
{
    private $contractService;
    private $contractDeviceService;
    private $data;

    public function __construct(ContractService $contractService, ContractDeviceService $contractDeviceService)
    {
        $this->contractService = $contractService;
        $this->contractDeviceService = $contractDeviceService;

        $this->data = [
            'icon' => 'flaticon2-box',
            'title' => 'Contrato nº: ',
            'menu_open_logistics' => 'kt-menu__item--open'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $customer_id = Auth::user()->customer_id;

        $data = $this->data;
        $data['logistics'] = $this->contractService->paginate();

        return response()->view('logistic.list', $data);
    }


    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['contract'] = $this->contractService->show($id);
        //$data['contracts'] = $this->contractDeviceService->findContractDevice($id);
        //$data['technologies'] = $this->technologieService->show($id);

        

        return view('logistic.new', $data);
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
}
