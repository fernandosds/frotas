<?php

namespace App\Http\Controllers\Fleets;

use App\Services\Fleets\CardCarService;
use App\Services\Fleets\CardService;
use Illuminate\Support\Facades\Auth;
use App\Services\Fleets\CarService;
use App\Http\Requests\Rent\CarRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarController extends Controller
{
    private $carService;
    private $driverCardCarService;
    private $cardService;
    private $data;

    /**
     * Ao cadastrar veiculo, mandar comando para ativar com qualquer cartao
     * Apos fazer vinculo, mudar configuração para ativar desbloqueio com cartao especifico
     * Apagar car~tao especifico ao desvincular
     *
     *
     *
     *
     * CarController constructor.
     * @param CarService $carService
     * @param CardService $cardService
     * @param CardCarService $driverCardCarService
     */
    public function __construct(CarService $carService, CardService $cardService, CardCarService $driverCardCarService)
    {
        $this->carService = $carService;
        $this->driverCardCarService = $driverCardCarService;
        $this->cardService = $cardService;

        $this->data = [
            'icon' => 'flaticon-truck',
            'title' => 'Veiculos',
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

        return response()->view('fleets.car.list', $data);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {

        $data = $this->data;
        $data['car'] = $this->carService->show($id);

        return response()->view('fleets.car.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('fleets.car.new', $data);
    }

    /**
     * @param CarRequest $request
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

        $data['cards_linkeds'] = $this->driverCardCarService->getCardByCarId($id);
        $data['cards_available'] = $this->cardService->getAvailableCards($id);

        return view('fleets.car.edit', $data);
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
