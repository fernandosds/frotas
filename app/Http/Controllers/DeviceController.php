<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DeviceRequest;
use App\Services\DeviceService;

class DeviceController extends Controller
{
    private $deviceService;
    private $data;

    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;

        $this->data = [
            'icon' => 'flaticon-map-location',
            'title' => 'Íscas',
            'menu_open_devices' => 'kt-menu__item--open'
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
        $data['devices'] = $this->deviceService->paginate();

        return response()->view('device.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        return view('device.new', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(DeviceRequest $request)
    {
    
        try {

            $this->deviceService->save($request);

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
        $data['device'] = $this->deviceService->show($id);

        return view('device.new', $data);
    }

    /**
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Int $id, DeviceRequest $request)
    {

        try {

            $this->deviceService->update($request, $request->id);

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
        $this->deviceService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
