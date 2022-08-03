<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LogService;
use App\Services\UserService;

class LogController extends Controller
{
    private $logService;
    private $userService;
    private $data;

    /**
     * LogController constructor.
     * @param LogService $logService
     */
    public function __construct(LogService $logService, UserService $userService)
    {
        $this->logService = $logService;
        $this->userService = $userService;

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
        $data['users'] = $this->userService->paginate();

        return response()->view('management.log.list', $data);
    }

    public function data(){

        $data['data'] = $this->logService->table(100);
        return response()->json($data);
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
