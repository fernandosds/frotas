<?php


namespace App\Repositories\Iscas;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\AbstractRepository;

use App\Models\Contract;

class ContractRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Contract $model
     */
    public function __construct(Contract $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public function showid(int $id)
    {

        $contract = DB::table('contracts')
            ->select(DB::raw('*'))
            ->where('customer_id', '=', $id)
            ->where('deleted_at', null)
            ->get();

        return $contract;
    }

    /**
     * @return mixed
     */
    public function contractCompleted()
    {

        $contractCompleted = $this->model
            ->select('*')
            ->where('status', '=', 1)
            ->get();

        return $contractCompleted;
    }

    /**
     * @param $customer
     * @return mixed
     */
    public function historyContract()
    {

        $historyContract = $this->model
            ->where('customer_id', '=', Auth::user()->customer_id)
            ->get();

        return $historyContract;
    }
}
