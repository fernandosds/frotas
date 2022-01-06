<?php


namespace App\Services;

use App\Repositories\CustomerRepository;
use App\Repositories\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerService
{
    public function __construct(CustomerRepository $customerRepository, LogRepository $log)
    {
        $this->customerRepository = $customerRepository;
        $this->log = $log;
    }

    /**
     * @return mixed
     */
    public function all()
    {

        return $this->customerRepository->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->customerRepository->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {

        // $dados = $request->all();
        $dados = $request->all();

        return $this->customerRepository->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $customer = $this->customerRepository->create($request->all());
        saveLog(['value' => $request['name'], 'type' => 'Cadastrou_o_cliente', 'local' => 'CustomerService', 'funcao' => 'save']);
       // $this->log->saveCustomerLog($customer);
        return $customer;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $customer = $this->customerRepository->update($id, $request->all());
        saveLog(['value' => $request['name'], 'type' => 'Atualizou_o_cliente', 'local' => 'CustomerService', 'funcao' => 'update']);
        //$this->log->updateCustomerLog($request->all());
        return $customer;
    }

    /**
     * @param Int $id
     * @return CustomerRepository|\Illuminate\Database\Eloquent\Model|object|void|null
     */
    public function show(Int $id)
    {

        $customer =  $this->customerRepository->showid($id);
        saveLog(['value' => $customer->name, 'type' => 'Monitorou_o_cliente', 'local' => 'CustomerService', 'funcao' => 'update']);
        return ($customer) ? $customer : abort(404);
    }

    /**
     * @param Int $id
     * @return bool
     */
    public function destroy(Int $id)
    {
        $customer = $this->show($id);

        saveLog(['value' => $customer->name, 'type' => 'Excluiu_o_cliente', 'local' => 'CustomerService', 'funcao' => 'destroy']);
       // $this->log->deleteCustomerLog($customer);
        return $this->customerRepository->delete($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        return $this->customerRepository->find($id);
    }


    /**
     * @param Request $request
     * @return CustomerRepository|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function search(Request $request)
    {

        return $this->customerRepository->search($request);
    }

    /**
     * @return CustomerRepository|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getAllCustomerDevice($customer_id = null)
    {
        return $this->customerRepository->getAllCustomerDevice($customer_id);
    }
}
