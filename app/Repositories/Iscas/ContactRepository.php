<?php


namespace App\Repositories\Iscas;

use Illuminate\Support\Facades\DB;

use App\Models\Contact;
use App\Repositories\AbstractRepository;

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
