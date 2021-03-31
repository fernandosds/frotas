<?php

namespace App\Http\Controllers;

use App\Services\UserService;
//use Illuminate\Http\Request;
//use App\User;

class HomeController extends Controller
{

    private $data;
    private $userService;

    /**
     * HomeController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {

        $this->userService = $userService;

        $this->data = [
            'icon' => 'flaticon-home-2',
            'title' => 'Home',
            'url' => ''
        ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $data = $this->data;

        //saveLog(['value' => 'Teste', 'type' => 'Acessou a página inicial', 'local' => 'HomeController', 'funcao' => 'index']);

        return view('index', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function accessDenied()
    {

        $data['managements'] = $this->userService->getAllAdmins();

        return view('access_denied', $data);
    }
}
