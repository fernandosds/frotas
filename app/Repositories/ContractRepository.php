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
        $contact = DB::table('contacts')
            ->select(DB::raw('*'))
            ->where('customer_id', '=', $id)
            ->where('deleted_at', null)
            ->get();

            

            return $contact;
    }
}
