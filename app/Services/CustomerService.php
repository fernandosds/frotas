<?php


namespace App\Services;

use App\Repositories\CustomerRepository;
use App\Repositories\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerService
{
    public function __construct(CustomerRepository $customer, LogRepository $log)
    {
        $this->customer = $customer;
        $this->log = $log;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->customer->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->customer->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {

        // $dados = $request->all();
        $dados = $request->all();

        return $this->customer->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {

        $customer = $this->customer->create($request->all());

        $this->log->saveCustomerLog($customer);

        return $customer;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {

        $customer = $this->customer->update($id, $request->all());

        return $customer;
    }

    /**
     * @param Int $id
     * @return CustomerRepository|\Illuminate\Database\Eloquent\Model|object|void|null
     */
    public function show(Int $id)
    {

        $customer =  $this->customer->showid($id);


        return ($customer) ? $customer : abort(404);
    }

    /**
     * @param Int $id
     * @return bool
     */
    public function destroy(Int $id)
    {

        return $this->customer->delete($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        return $this->customer->find($id);
    }


    /**
     * @param Request $request
     * @return CustomerRepository|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function search(Request $request)
    {

        return $this->customer->search($request);
    }
}
