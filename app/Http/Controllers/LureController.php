<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LureRequest;
use App\Services\LureService;

class LureController extends Controller
{
    private $lureService;
    private $data;

    public function __construct(LureService $lureService)
    {
        $this->lureService = $lureService;

        $this->data = [
            'icon' => 'flaticon-map-location',
            'title' => 'Íscas',
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
        $data['lures'] = $this->lureService->paginate();

        return response()->view('lure.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('lure.new', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(LureRequest $request)
    {
    
        try {

            $this->lureService->save($request);

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
        $data['lure'] = $this->lureService->show($id);

        return view('lure.new', $data);
    }

    /**
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Int $id, LureRequest $request)
    {

        try {

            $this->lureService->update($request, $request->id);

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
     * @param  \App\Models\Lure  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $this->lureService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
