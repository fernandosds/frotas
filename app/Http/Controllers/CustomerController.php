<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customerService;
    private $data;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;

        $this->data = [
            'icon' => 'flaticon-users',
            'title' => 'Clientes',
            'menu_open_customers' => 'kt-menu__item--open'
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
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {

        $data = $this->data;
        $data['customers'] = $this->customerService->show($id);

        //print_r($data);
        //    die();

        return response()->view('customer.show_list', $data);
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
     * @param CustomerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(CustomerRequest $request)
    {

        try {

            $this->customerService->save($request);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }


        // return $this->customerService->save($request);
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
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Int $id, CustomerRequest $request)
    {

        try {

            $this->customerService->update($request, $request->id);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $this->customerService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
