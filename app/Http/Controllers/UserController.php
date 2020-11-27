<?php

namespace App\Http\Controllers;


use App\User;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('user.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {

        $users = $this->userService->all();
        return response()->view('user.users', compact('users'));
    }

    public function create(Request $request)
    {
        return view('user.formuser');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $users = $this->userService->store($request);
        return "ok";//redirect()->route('users');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Int $id)
    {

        $post = $this->userService->update($request, $id);

        return redirect()->route('users');

        //return response()->json($this->userService->update($request, $id));
    }

    /**
     * @param Int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Int $id)
    {
        return response()->json($this->userService->show($id));
    }

    public function edit($id)
    {

        $user = $this->userService->edit($id);

        return view('user.formuser', compact('user'));
    }


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
