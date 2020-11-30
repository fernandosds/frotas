<?php


namespace App\Services;

use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerService
{
    public function __construct(CustomerRepository $customer)
    {
        $this->customer = $customer;
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

        print_r($request->input());die;

        $request->merge(['password' => Hash::make($request->password)]);
        $customer = $this->customer->create($request->all());

        return $customer;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {

        if ($request->password) {
            $request->merge(['password' => Hash::make($request->password)]);
        }
        $customer = $this->customer->update($id, $request->all());

        return $customer;
    }



    public function show(Int $id)
    {

        $customer =  $this->customer->find($id);

        return ($customer) ? $customer : abort(404);
    }


    /**
     * @param Int $id
     */
    public function destroy(Int $id)
    {

        return $this->customer->delete($id);
    }

    public function edit($id)
    {
        return $this->customer->find($id);
    }
}
