<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    private $userService;
    private $data;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param ResetMail $resetMail
     */
    public function __construct(UserService $userService = null)
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function receiveData($email)
    {
        return  DB::table('users')
            ->select('name', 'status', 'email', 'customer_id', 'deleted_at')
            ->where('email', $email)
            ->whereNull('deleted_at')
            ->first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerLog($data, $message)
    {

        /*  Cria o timestamp  */

        $unixTime = time();
        $time = new \DateTime();
        $time->setTimestamp($unixTime);
        $timestamps = $time->format('Y-m-d H:i:s');

        $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);

        $values =  [
            'user_name' => strval($data['name']),
            'customer_id' => $data['customer_id'],
            'description' => "$message",
            'created_at' => $timestamps,
            'updated_at' => $timestamps,
            'host_ip' => "$ip",
        ];

        $logUser =   DB::table('logs')->insertGetId($values);

        return $logUser;
    }
}
