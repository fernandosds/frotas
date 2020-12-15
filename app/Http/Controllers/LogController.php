<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LogService;

class LogController extends Controller
{
    private $logService;
    private $data;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;

        $this->data = [
            'icon' => 'flaticon2-contract',
            'title' => 'Logs do sistema',
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

        return response()->view('log.list', $data);
    }



    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {

        $data = $this->data;
        $data['logs'] = $this->logService->showid($id);

        //print_r($data);
        //die();
         
        return response()->view('log.list', $data);
    }

    

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    /**
    public function new()
    {

        $data = $this->data;
        
        return view('device.log.new', $data);
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

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
  /**
     public function edit(Int $id)
    {

        $data = $this->data;
        $data['log'] = $this->logService->show($id);

        return view('device.log.new', $data);
    }
 */
    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Int $id, Request $request)
    {
        
        try {

            $this->logService->update($request, $request->id);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $this->logService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
