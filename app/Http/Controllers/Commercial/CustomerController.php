<?php

namespace App\Http\Controllers\Commercial;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    private $customerService;

    /**
     * CustomerController constructor.
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {

        $customer = $this->customerService->search($request);

        if ($customer) {
            return response()->json(['status' => 'success', 'data' => $customer]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'usuário não encontrado!']);
        }
    }

}
