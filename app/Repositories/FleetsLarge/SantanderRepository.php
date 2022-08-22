<?php


namespace App\Repositories\FleetsLarge;


use App\Models\BancoSantander;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Auth;

class SantanderRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(BancoSantander $model)
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

    /**
     * Find one register
     *
     * @param string $chassis
     * @return mixed
     */
    public function getPlate()
    {
        return
            $this->model->select('placa', 'chassis')
            ->get();
    }

    public function removePlates($removePlate)
    {
        return $this->model->whereNotIn('placa', $removePlate)->get();
    }
}
