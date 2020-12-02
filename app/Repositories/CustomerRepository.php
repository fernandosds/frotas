<?php


namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Customer $model
     */
    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

}
