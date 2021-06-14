<?php

namespace App\Http\Controllers\Fleets;

use App\Services\Fleets\CardCarService;
use App\Services\Fleets\CarService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\Fleets\CardService;
use App\Http\Requests\Rent\CardRequest;
use Illuminate\Http\Request;

class CardController extends Controller
{
    private $cardService;
    private $driverCardCarService;
    private $carService;
    private $data;

    /**
     * CardController constructor.
     * @param CardService $cardService
     * @param CarService $cardService
     * @param CardCarService $driverCardCarService
     */
    public function __construct(CardService $cardService, CardCarService $driverCardCarService, CarService $carService)
    {
        $this->cardService = $cardService;
        $this->driverCardCarService = $driverCardCarService;
        $this->carService = $carService;

        $this->data = [
            'icon' => 'fa fa-credit-card',
            'title' => 'Cartões',
            'menu_open_cards' => 'kt-menu__item--open'
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
        $data['cards'] = $this->cardService->paginate();

        return response()->view('fleets.card.list', $data);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Cards\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {

        $data = $this->data;
        $data['card'] = $this->cardService->show($id);

        return response()->view('fleets.card.list', $data);
    }

    /**
     * @return \Illuminate\Cards\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('fleets.card.new', $data);
    }

    /**
     * @param CardRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(CardRequest $request)
    {

        try {

            $request->merge([
                'customer_id' => Auth::user()->customer_id
            ]);

            $this->cardService->save($request);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param Int $id
     * @return \Illuminate\Cards\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['card'] = $this->cardService->show($id);
        $data['cars_linkeds'] = $this->driverCardCarService->getCarsByCardId($id);
        $data['cars_available'] = $this->carService->getAvailableCars($id);
        return view('fleets.card.edit', $data);
    }

    /**
     * @param Int $id
     * @param CardRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CardRequest $request)
    {

        try {

            $this->cardService->update($request, $request->id);

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
        $this->cardService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
