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

    /**
     * @return \Illuminate\Http\Response
     */
    public function historyContract()
    {

        $data = $this->data;

        $data['contract'] = $this->contractService->historyContract();

        return view('contracts.list', $data);

    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {

        $data = $this->data;

        $data['contract'] = $this->contractService->show($id);

        return view('contracts.show', $data);
    }
}
