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
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Int $id, Request $request)
    {

       //$contact = Contact::firstOrCreate(['id' => $request->id]);
       //$contact->number = $request->number;
       //$contact->save();






        try {

            $this->contactService->update($request, $request->id);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }
}
