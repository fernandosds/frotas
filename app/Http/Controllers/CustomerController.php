<?php

namespace App\Http\Controllers;

//use App\Http\Requests\CustomerRequest;
use App\Services\CustumerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customerService;
    private $data;

    public function __construct(CustumerService $customerService)
    {
        $this->customerService = $customerService;

        $this->data = [
            'icon' => 'flaticon-user',
            'title' => 'Clientes',
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
        $data['customers'] = $this->customerService->paginate();

        return response()->view('customer.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('customer.new', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {

        return $this->customerService->save($request);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['customer'] = $this->customerService->show($id);

        return view('customer.new', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $this->customerService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
