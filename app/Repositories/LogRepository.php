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

    public function saveCustomerLog($customer)
    {

        $logCustomer = $this->model
            ->create([

                'user_id' => Auth::user()->id,
                'customer_id' => $customer->id,
                'description' => "Cadastrou o cliente {$customer->name}", 
            ]);

        $logCustomer->save();

        return $logCustomer;
    }
}
