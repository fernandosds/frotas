<?php

namespace App\Http\Controllers\Fleets;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\Fleets\DriverService;
use App\Http\Requests\Fleets\DriverRequest;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    private $driverService;
    private $data;


    /**
     * UserController constructor.
     * @param DriverService $driverService
     * 
     */
    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;

        $this->data = [
            'icon' => 'flaticon2-user',
            'title' => 'Lista de motoristas',
            'menu_open_drivers' => 'kt-menu__item--open'
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
        $data['drivers'] = $this->driverService->paginate();

        return response()->view('fleets.driver.list', $data);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Drivers\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {

        $data = $this->data;
        $data['driver'] = $this->driverService->show($id);

        return response()->view('fleets.driver.list', $data);
    }

    /**
     * @return \Illuminate\Drivers\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('fleets.driver.new', $data);
    }

    /**
     * @param DriverRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(DriverRequest $request)
    {


        try {

            $request->merge([
                'customer_id' => Auth::user()->customer_id
            ]);

            $this->driverService->save($request);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param Int $id
     * @return \Illuminate\Driver\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['driver'] = $this->driverService->show($id);

        return view('fleets.driver.new', $data);
    }

    /**
     * @param Int $id
     * @param CustomerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DriverRequest $request)
    {

        try {

            $this->driverService->update($request, $request->id);

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
        $this->driverService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}