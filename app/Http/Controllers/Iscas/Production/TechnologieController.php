<?php

namespace App\Http\Controllers\Iscas\Production;

use App\Http\Controllers\Controller;
use App\Http\Requests\TechnologieRequest;
use App\Services\Iscas\TechnologieService;

class TechnologieController extends Controller
{
    private $technologieService;
    private $data;

    /**
     * TechnologieController constructor.
     * @param TechnologieService $technologieService
     */
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

        return response()->view('production.device.technologie.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('production.device.technologie.new', $data);
    }


    /**
     * @param TechnologieRequest $request
     * @return \Illuminate\Http\JsonResponse
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

        return view('production.device.technologie.new', $data);
    }

    /**
     * @param Int $id
     * @param TechnologieRequest $request
     * @return \Illuminate\Http\JsonResponse
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
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Int $id)
    {
        $this->technologieService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
