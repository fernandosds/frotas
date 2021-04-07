<?php


namespace App\Repositories;
use App\Models\UserMenu;


class UserAccessRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param UserMenu $model
     */
    public function __construct(UserMenu $model)
    {
        $this->model = $model;
    }

    public function updateUserAccess($id, $request)
    {
        try {
            $data = [];
            foreach ($request as $menuAccess) {
                $data[] = [
                    'user_id'          => $id,
                    'list_menu_id'    => $menuAccess,
                ];
            }

            $this->model->insert($data);
            return response()->json(['status' => 'success', 'data' => $data], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @return mixed
     */
    public function findByUserId($id)
    {
        $userId = $this->model
            ->where('user_id', '=', $id)
            ->first();

        return $userId;
    }
}
