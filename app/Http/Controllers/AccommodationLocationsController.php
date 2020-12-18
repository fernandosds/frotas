<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AccommodationLocationsService;
use App\Http\Requests\AccommodationLocationRequest;

class AccommodationLocationsController extends Controller
{
    private $accommodationLocationsService;
    private $data;

    public function __construct(AccommodationLocationsService $accommodationLocationsService)
    {
        $this->accommodationLocationsService = $accommodationLocationsService;

        $this->data = [
            'icon' => 'flaticon2-gear',
            'title' => 'Local de Acomodação',
            'menu_open_locations' => 'kt-menu__item--open'
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
        $data['accommodationLocations'] = $this->accommodationLocationsService->paginate();

        return response()->view('accommodationlocations.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('accommodationlocations.new', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {

        try {

            $this->accommodationLocationsService->save($request);

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
        $data['accommodationLocation'] = $this->accommodationLocationsService->show($id);

        return view('accommodationlocations.new', $data);
    }

    /**
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Int $id, AccommodationLocationRequest $request)
    {

        try {

            $this->accommodationLocationsService->update($request, $request->id);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

 
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccommodationLocation  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $this->accommodationLocationsService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
