<?php


namespace App\Repositories;


use App\User;
use Illuminate\Support\Facades\Auth;

class UserRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getAllAdmins()
    {
        return $this->model->where("type", '=', 'sat')
            ->where('status', 1)
            ->where('access_level', '=', 'management')
            ->get();
    }

    /**
     * @param Int $id
     * @return mixed
     */
    public function find(Int $id)
    {

        if(Auth::user()->type == "ext"){
            return $this->model->where('customer_id', Auth::user()->customer_id)
                ->where('id',$id)
                ->first();
        }else{
            return $this->model->where('id',$id)->first();
        }

        return $this->model->where('id', $id)->first();
    }

    /**
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email)
    {
        $checkEmail = $this->model
            ->where('email', '=', $email)
            ->first();

        return $checkEmail;
    }



}
