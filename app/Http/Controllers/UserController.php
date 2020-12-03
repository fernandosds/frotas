<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    private $userService;
    private $data;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        $this->data = [
            'icon' => 'flaticon-user',
            'title' => 'Usuários',
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

        return response()->view('user.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {
        $data = $this->data;
        return view('user.new', $data);
    }

    /**
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function save(UserRequest $request)
    {

        try {

          
            $this->userService->save($request);
     

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
        $data['user'] = $this->userService->show($id);

        return view('user.new', $data);
    }

    /**
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Int $id, UserRequest $request )
    {

        try {

        
            $this->userService->update($request, $request->id);
  

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }

    }

    /**
     * @param Int $id
     * @return \Illuminate\Http\JsonResponse
     */
    //public function show(Int $id)
    //{
    //    return response()->json($this->userService->show($id));
    //}




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $this->userService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }
}
