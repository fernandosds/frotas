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

    public function updateCustomerLog($customer)
    {
        $logCustomer = $this->model
            ->create([
                'user_id' => Auth::user()->id,
                'customer_id' => $customer['id'],
                'description' => "Atualizou os dados do cliente {$customer['name']}",
            ]);

        $logCustomer->save();
        return $logCustomer;
    }

    public function deleteCustomerLog($customer)
    {
        $logCustomer = $this->model
            ->create([
                'user_id' => Auth::user()->id,
                'customer_id' => $customer->id,
                'description' => "Deletou o cliente {$customer->name}",
            ]);

        $logCustomer->save();
        return $logCustomer;
    }

    public function saveBoardingLog($boarding, $device)
    {
        $logCustomer = $this->model
            ->create([
                'user_id' => Auth::user()->id,
                'customer_id' => $boarding->customer_id,
                'description' => "Iniciou o embarque da isca {$device}",
            ]);

        $logCustomer->save();
        return $logCustomer;
    }

    public function finishBoardingLog($boarding, $device)
    {
        $logCustomer = $this->model
            ->create([
                'user_id' => Auth::user()->id,
                'customer_id' => $boarding->customer_id,
                'description' => "Encerrou o embarque da isca {$device}",
            ]);

        $logCustomer->save();
        return $logCustomer;
    }

    public function monitoringBoarding($device)
    {
        $logCustomer = $this->model
            ->create([
                'user_id' => Auth::user()->id,
                'customer_id' =>  Auth::user()->customer_id,
                'description' => "Monitorou a isca {$device}",
            ]);

        $logCustomer->save();
        return $logCustomer;
    }
}
