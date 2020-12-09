<?php

namespace App\Http\Controllers;

use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    private $contactService;
    private $data;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;

        $this->data = [
            'icon' => 'flaticon-users',
            'title' => 'Clientes',
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
        $data['contacts'] = $this->contactService->paginate();

        return response()->view('contacts.list', $data);
    }

    
    
    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {

        $data = $this->data;
        $data['contacts'] = $this->contactService->show($id);
    
        return response()->view('contacts.list', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        // print_r($request->all());
        // die;

        try {

            $this->contactService->save($request);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $this->contactService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
