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
    /**
    public function search($cpf_cnpj)
    {

        
        $customer = DB::table('customers')
            ->select(DB::raw('*'))
            ->where('cpf_cnpj', '=', $cpf_cnpj)
            ->where('deleted_at', null)
            ->first();

            return $customer;
    }
     */

    public function search(Request $request)
    {
    
        //83.838.312/0001-04

        $customer = DB::table('customers')
            ->select(DB::raw('*'))
            ->where('cpf_cnpj', '=', $request['cpf_cnpj'])
            ->where('deleted_at', null)
            ->first();

            print_r($customer);
            die();

        return $customer;
    }
}
