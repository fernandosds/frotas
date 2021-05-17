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

        if (Auth::user()->type == "ext") {
            return $this->model->where('customer_id', Auth::user()->customer_id)
                ->where('id', $id)
                ->first();
        } else {
            return $this->model->where('id', $id)->first();
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

    public function updateUserAccess($id, $request)
    {
        try {
            $user = $this->model->find($id);
            $user->listMenu()->detach();
            $data = [];
            foreach ($request as $menuAccess) {
                $data[] = [
                    'user_id'          => $id,
                    'list_menu_id'    => $menuAccess,
                ];
            }
            $this->model->listMenu()->syncWithoutDetaching($data);
            return response()->json(['status' => 'success', 'data' => $data], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }
}
