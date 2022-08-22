<?php


namespace App\Repositories;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Log $model
     */
    public function __construct(Log $model)
    {
        $this->model = $model;
    }

    public function table($limit){
        return $this->model->orderBy('id', 'desc')->limit($limit)->get();
    }

    public function saveLog($user, $data, $ip = null)
    {
        $ip = null;
        if (isset($_COOKIE['ipClient'])) {
            $ip = strval($_COOKIE['ipClient']);
        }

        $logUser = $this->model
            ->create([
                'user_name' => $user,
                'user_id' => Auth::user()->id,
                'customer_id' => Auth::user()->customer_id,
                'description' => "$data",
                'host_ip' => "$ip",
            ]);

        $logUser->save();
        return $logUser;
    }

    public function orderLog(){
        return $this->model->orderBy('id', 'Desc');
    }

}