<?php


namespace App\Repositories;

use App\Models\Log;

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
        print_r($customer);
        die();
    }

}
