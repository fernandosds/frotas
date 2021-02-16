<?php

namespace App\Http\Controllers\Iscas\Commercial;

use App\Http\Controllers\Controller;
use App\Services\Iscas\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    private $contactService;
    private $data;

    /**
     * ContactController constructor.
     * @param ContactService $contactService
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;

        $this->data = [
            'icon' => 'flaticon-users',
            'title' => 'Clientes',
        ];
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->data;
        $data['contacts'] = $this->contactService->paginate();

        return response()->view('commercial.customer.contacts.list', $data);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Int $id)
    {

        $data = $this->data;
        $data['contacts'] = $this->contactService->show($id);
    
        return response()->view('commercial.customer.contacts.list', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        try {
           
            $this->contactService->save($request);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Int $id)
    {
        $this->contactService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
