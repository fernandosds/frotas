<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TechnologieRequest;
use App\Services\TechnologieService;

class TechnologieController extends Controller
{
    private $technologieService;
    private $data;

    public function __construct(TechnologieService $technologieService)
    {
        $this->technologieService = $technologieService;

        $this->data = [
            'icon' => 'flaticon-map-location',
            'title' => 'Tecnologias',
            'menu_open_technologies' => 'kt-menu__item--open'
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
        $data['technologies'] = $this->technologieService->paginate();

        return response()->view('device.technologie.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('device.technologie.new', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(TechnologieRequest $request)
    {
    
        try {

            $this->technologieService->save($request);

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
        $data['technologie'] = $this->technologieService->show($id);

        return view('device.technologie.new', $data);
    }

    /**
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Int $id, TechnologieRequest $request)
    {

        try {

            $this->technologieService->update($request, $request->id);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
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
     * @param  \App\Models\Technologie  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $this->technologieService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
