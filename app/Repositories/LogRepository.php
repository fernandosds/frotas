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

    public function saveLog($user, $data)
    {

        $logUser = $this->model
            ->create([
                'user_name' => $user,
                'customer_id' => Auth::user()->customer_id,
                'description' => "$data",
            ]);

        $logUser->save();
        return $logUser;
    }
}
