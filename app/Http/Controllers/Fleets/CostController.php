<?php

namespace App\Http\Controllers\Fleets;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Services\Rent\CostService;
use Illuminate\Http\Request;

class CostController extends Controller
{
    private $costService;
    private $data;

    /**
     * UserController constructor.
     * @param CostService $cardService
     * 
     */
    public function __construct(CostService $costService)
    {
        $this->costService = $costService;

        $this->data = [
            'icon' => 'flaticon2-bar-chart',
            'title' => 'Lista de custos',
            'menu_open_costs' => 'kt-menu__item--open'
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
        $data['costs'] = $this->costService->paginate();

        return response()->view('rent.cost.list', $data);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Cards\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {

        $data = $this->data;
        $data['cost'] = $this->costService->show($id);

        return response()->view('rent.cost.list', $data);
    }

    /**
     * @return \Illuminate\Cards\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('rent.cost.new', $data);
    }

    /**
     * @param CustomerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {


        try {

            $request->merge([
                'customer_id' => Auth::user()->customer_id
            ]);


            $this->costService->save($request);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param Int $id
     * @return \Illuminate\Costs\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['cost'] = $this->costService->show($id);

        return view('rent.cost.new', $data);
    }

    /**
     * @param Int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {

        try {

            $this->costService->update($request, $request->id);

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
        $this->costService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
