<?php

namespace App\Http\Controllers\Rent;

use Illuminate\Support\Facades\Auth;
use App\Services\Rent\CarService;
use App\Http\Requests\Rent\CarRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarController extends Controller
{
    private $carService;
    private $data;


    /**
     * UserController constructor.
     * @param CarService $carService
     * 
     */
    public function __construct(CarService $carService)
    {
        $this->carService = $carService;

        $this->data = [
            'icon' => 'flaticon-truck',
            'title' => 'Lista de carros',
            'menu_open_cars' => 'kt-menu__item--open'
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
        $data['cars'] = $this->carService->paginate();

        return response()->view('rent.car.list', $data);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {

        $data = $this->data;
        $data['car'] = $this->carService->show($id);

        return response()->view('rent.car.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('rent.car.new', $data);
    }

    /**
     * @param CustomerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(CarRequest $request)
    {


        try {

            $request->merge([
                'customer_id' => Auth::user()->customer_id
            ]);

            $this->carService->save($request);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['car'] = $this->carService->show($id);

        return view('rent.car.new', $data);
    }

    /**
     * @param Int $id
     * @param CustomerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CarRequest $request)
    {

        try {

            $this->carService->update($request, $request->id);

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
        $this->carService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
