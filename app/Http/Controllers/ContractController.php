<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use App\Services\ContractService;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    private $contractService;
    private $customerService;
    private $data;

    /**
     * ContractController constructor.
     * @param ContractService $contractService         
     * @param CustomerService $customerService         
     */

    public function __construct(ContractService $contractService, CustomerService $customerService)
    {
        $this->contractService = $contractService;
        $this->customerService = $customerService;

        $this->data = [
            'icon' => 'flaticon2-contract',
            'title' => 'Contrato',
            'menu_open_contracts' => 'kt-menu__item--open'
        ];
    }

    public function historyContract()
    {

        try {


            $customer = $this->customerService->show(Auth::user()->customer_id);

            $data = $this->data;

            $data['contract'] = $this->contractService->historyContract($customer);

            return response()->view('commercial.contract.list_contract_history', $data, 200);
        } catch (\Exception $e) {

            return response()->view('commercial.contract.history_empty', array(), 404);
        }
    }
}
