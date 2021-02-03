<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $userService;
    private $data;


    /**
     * UserController constructor.
     * @param UserService $userService
     * @param ResetMail $resetMail        
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;


        $this->data = [
            'icon' => 'flaticon-user',
            'title' => 'Usuários',
            'menu_open_users' => 'kt-menu__item--open'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {

        return $this->userService->resetPassword($request->email);
    }
}
