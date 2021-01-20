<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Services\ContractService;
use Illuminate\Support\Facades\Auth;

class LogisticController extends Controller
{
    private $contractService;
    private $data;

    public function __construct(ContractService $contractService)
    {
        $this->contractService = $contractService;

        $this->data = [
            'icon' => 'flaticon2-box',
            'title' => 'Contratos Pendentes',
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
}
