<?php


namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Models\Contract;

class ContractRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Contact $model
     */
    public function __construct(Contract $model)
    {
        $this->model = $model;
    }

    public function showid(int $id)
    {
        //print_r($id);
        //die();

        $contract = DB::table('contracts')
            ->select(DB::raw('*'))
            ->where('customer_id', '=', $id)
            ->where('deleted_at', null)
            ->get();



        return $contract;
    }


    public function contractCompleted()
    {
        //print_r($id);
        //die();

        $contractCompleted = $this->model
            ->select('*')
            ->where('status', '=', 1) 
            ->get();



        return $contractCompleted;
    }

}
