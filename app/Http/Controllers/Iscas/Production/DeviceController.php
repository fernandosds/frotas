<?php

namespace App\Http\Controllers\Iscas\Production;

use App\Http\Controllers\Controller;
use App\Imports\DeviceImport;
use App\Services\Iscas\TechnologieService;
use App\Http\Requests\DeviceRequest;
use App\Services\DeviceService;
use Maatwebsite\Excel\Facades\Excel;

class DeviceController extends Controller
{
    private $deviceService;
    private $technologieService;
    private $data;

    /**
     * DeviceController constructor.
     * @param DeviceService $deviceService
     * @param TechnologieService $technologieService
     */
    public function __construct(DeviceService $deviceService, TechnologieService $technologieService)
    {
        $this->deviceService = $deviceService;
        $this->technologieService = $technologieService;

        $this->data = [
            'icon' => 'flaticon-placeholder-3',
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

        return response()->view('production.device.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        $data['technologies'] = $this->technologieService->all();

        return view('production.device.new', $data);
    }

    /**
     * @param DeviceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(DeviceRequest $request)
    {

        $array = Excel::toArray(new DeviceImport, $request->file('file'));

        $inserts = $this->deviceService->save($array);

        return response()->json([
            'status' => 'success',
            'message' => count($inserts)
        ], 200);

    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['device'] = $this->deviceService->show($id);
        $data['technologies'] = $this->technologieService->all();

        return view('production.device.new', $data);
    }

    /**
     * @param Int $id
     * @param DeviceRequest $request
     * @return \Illuminate\Http\JsonResponse
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
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Int $id)
    {

        $destroy = $this->deviceService->destroy($id);

        if($destroy){
            return response()->json(['status' => 'success', 'message' => $destroy.' Deleted successfully']);
        }else{
            return response()->json(['status' => 'error', 'message' => $destroy.' O dispositivo esta em uso por um cliente!']);
        }

    }
}
