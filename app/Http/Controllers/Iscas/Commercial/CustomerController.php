<?php

namespace App\Http\Controllers\Iscas\Commercial;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customerService;
    private $data;

    /**
     * CustomerController constructor.
     * @param CustomerService $customerService
     */
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

        return response()->view('commercial.customer.list', $data);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {

        $data = $this->data;
        $data['customers'] = $this->customerService->show($id);

        return response()->view('commercial.customer.show_list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('commercial.customer.new', $data);
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

            return response()->json(['status' => 'error', 'errors' => $e->getMessage()], 400);
        }

    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['customer'] = $this->customerService->show($id);

        return view('commercial.customer.new', $data);
    }

    /**
     * @param Int $id
     * @param CustomerRequest $request
     * @return \Illuminate\Http\JsonResponse
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
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Int $id)
    {
        $this->customerService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
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
