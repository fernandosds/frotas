<?php


namespace App\Repositories\FleetsLarge;


use App\Models\BancoPSA;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Auth;

class PsaRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(BancoPSA $model)
    {
        $this->model = $model;
    }

    public function table($limit)
    {
        return $this->model->limit($limit)->get();
    }

    /**
     * Find one register
     *
     * @param string $chassis
     * @return mixed
     */
    public function findByChassi($chassis)
    {
        return $this->model->where('chassis', $chassis)
            ->first();
    }
}
