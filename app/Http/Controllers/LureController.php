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
            'icon' => 'flaticon-user',
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

        return $this->lureService->save($request);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['lureService'] = $this->lureService->show($id);

        return view('lureService.new', $data);
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
        $this->lureService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
