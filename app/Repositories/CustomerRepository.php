<?php


namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use PhpParser\Node\Expr\Print_;

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

    public function getAllCustomerDevice()
    {
        return $this->model
            ->select('id', 'name')
            ->whereExists(function ($query) {
                $query->select("model")
                    ->from('devices')
                    ->whereRaw('customer_id = customers.id');
            })
            ->orderBy('name', 'asc')
            ->get();
    }


    public function search(Request $request)
    {

        $customer = DB::table('customers')
            ->select(DB::raw('*'))
            ->where('cpf_cnpj', '=', $request->cpf_cnpj)
            ->where('deleted_at', null)
            ->first();
        return $customer;
    }
}
