<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AccommodationLocationsService;

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

        return $this->accommodationLocationsService->save($request);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['accommodationLocationsService'] = $this->accommodationLocationsService->show($id);

        return view('accommodationlocations.new', $data);
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
        $this->accommodationLocationsService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
