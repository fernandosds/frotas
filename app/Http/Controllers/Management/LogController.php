<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LogService;

class LogController extends Controller
{
    private $logService;
    private $data;

    /**
     * LogController constructor.
     * @param LogService $logService
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;

        $this->data = [
            'icon' => 'flaticon2-contract',
            'title' => 'Logs do sistema',
            'menu_open_logs' => 'kt-menu__item--open'
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
        $data['logs'] = $this->logService->paginate();


        return response()->view('management.log.list', $data);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    /**   public function show(Int $id)
    {

        $data = $this->data;
        $data['logs'] = $this->logService->showid($id);

        return response()->view('log.list', $data);
    }
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        try {

            $this->logService->save($request);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }
}
