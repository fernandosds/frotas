<?php


namespace App\Repositories;

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

}
