<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TypeOfLoadRequest;
use App\Services\TypeOfLoadService;

class TypeOfLoadController extends Controller
{
    private $typeOfLoadService;
    private $data;

    public function __construct(TypeOfLoadService $typeOfLoadService)
    {
        $this->typeOfLoadService = $typeOfLoadService;

        $this->data = [
            'icon' => 'flaticon-truck',
            'title' => 'Tipos de cargas',
            'menu_open_loads' => 'kt-menu__item--open',
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
        $data['types_of_loads'] = $this->typeOfLoadService->paginate();

        return response()->view('typeofload.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('typeofload.new', $data);
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

            $this->typeOfLoadService->save($request);

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
        $data['types_of_load'] = $this->typeOfLoadService->show($id);

        return view('typeofload.new', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    
     /**
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Int $id, TypeOfLoadRequest $request)
    {

        try {

            $this->typeOfLoadService->update($request, $request->id);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeOfLoad  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $this->typeOfLoadService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
