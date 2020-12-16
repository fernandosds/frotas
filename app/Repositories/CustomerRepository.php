<?php


namespace App\Repositories;
use Illuminate\Support\Facades\DB;
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

    public function showid(int $id)
    {
        $customer = DB::table('customers')
            ->select(DB::raw('*'))
            ->where('id', '=', $id)
            ->where('deleted_at', null)
            ->first();

            return $customer;
    }

    public function search(int $cpf_cnpj)
    {
        $customer = DB::table('customers')
            ->select(DB::raw('*'))
            ->where('cpf_cnpj', '=', $cpf_cnpj)
            ->where('deleted_at', null)
            ->first();

            return $customer;
    }

}
