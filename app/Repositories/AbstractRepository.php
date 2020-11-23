<?php


namespace App\Repositories;


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
        return $this->findOrFail($id)->update($data);
    }


    /**
     * Delete one register
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->findOrFail($id)->delete();
    }
}
