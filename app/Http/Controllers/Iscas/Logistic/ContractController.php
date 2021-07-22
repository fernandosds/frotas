<?php

namespace App\Http\Controllers\Iscas\Logistic;

use App\Http\Controllers\Controller;
use App\Services\Iscas\ContractDeviceService;
use App\Services\Iscas\ContractService;
use Illuminate\Http\Request;

class ContractController extends Controller
{

    private $contractService;
    private $contractDeviceService;
    private $data;

    public function __construct(ContractService $contractService, ContractDeviceService $contractDeviceService)
    {
        $this->contractService = $contractService;
        $this->contractDeviceService = $contractDeviceService;

        $this->data = [
            'icon' => 'file-text',
            'title' => 'Logística > Contratos',
            'menu_open_logistics' => 'kt-menu__item--open'
        ];
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['contract'] = $this->contractService->show($id);

        return view('logistic.new', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $checkStatus =  $this->contractDeviceService->checkStatusContractDevice($request->id);

            if ($checkStatus > 0) {
                return response()->json(['status' => 'error', 'message' => 'É necessário vincular os dispositivos antes de confirmar.'], 200);
            }

            $this->contractService->update($request, $request->id);

            saveLog(['value' => $request->i, 'type' => 'Finalizou o contrato', 'local' => 'ContractController', 'funcao' => 'update']);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contractCompleted()
    {
        $data = $this->data;
        $data['logistics'] = $this->contractService->contractCompleted();

        return response()->view('logistic.contracts.list', $data);
    }


    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {
        $data = $this->data;
        $data['contract'] = $this->contractService->show($id);

        return view('logistic.contracts.new', $data);
    }
}
