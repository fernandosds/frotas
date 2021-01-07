<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $userService;
    private $data;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        $this->data = [
            'icon' => 'flaticon-avatar',
            'title' => 'Profile do sistema',
            'menu_open_logs' => 'kt-menu__item--open'
        ];
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editprofile()
    {

        $id = Auth::user()->id;

        $data = $this->data;
        $data['profile'] = $this->userService->show($id);

        return view('profile.new', $data);
    }


    /**
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request)
    {
        $id = Auth::user()->id;

        try {

            $this->userService->update($request, $id);
            return response()->json(['status' => 'success'], 200);
        
        } catch (\Exception $e) {
        
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        
        }
    }
}
