<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $data['typeofloads'] = $this->typeOfLoadService->paginate();

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

        return $this->typeOfLoadService->save($request);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['typeOfLoadService'] = $this->typeOfLoadService->show($id);

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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $this->typeOfLoadService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
