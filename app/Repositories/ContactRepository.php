<?php


namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Models\Contact;

class ContactRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Contact $model
     */
    public function __construct(Contact $model)
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
