<?php


namespace App\Repositories;


use Illuminate\Support\Facades\Auth;

class AbstractRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Find one register
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Find first register
     *
     * @return mixed
     */
    public function first()
    {

        return $this->model->first();
    }

    public function show(int $id)
    {
        return $this->model->where('id', $id)->first();

    }

    /**
     * Get all registers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {

        return $this->model->all();
    }

    /**
     * @param Int $limit
     * @param null $customer_id
     * @return mixed
     */
    public function paginate(Int $limit, $customer_id = null)
    {

        if($customer_id){
            return $this->model->where('customer_id',$customer_id)->orderBy('id','desc')->paginate($limit);
        }

        return $this->model->orderBy('id','desc')->paginate($limit);

    }

    /**
     * Create new register
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update one register
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {

        return $this->find($id)->update($data);

    }


    /**
     * Delete one register
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {

        return $this->model->find($id)->delete();

    }
}
