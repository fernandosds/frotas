<?php


namespace App\Services;


use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;


class PermissionService
{
    private $permissionRepository;


    /**
     * UserService constructor.
     * @param PermissionRepository $userRepository
     * 
     */
    public function __construct(PermissionRepository $permissionRepository)
    {

        $this->permissionRepository  = $permissionRepository;
    }


    /**
     * @param Int $id
     * @return mixed|void
     */
    public function show(Int $id)
    {
        $permissionByUserId =  $this->permissionRepository->findByUserId($id);
        return ($permissionByUserId) ? $permissionByUserId : abort(404);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updatePermission(Request $request, $id)
    {
        $userPermission = $this->permissionRepository->updatePermission($id, $request->all());
        return $userPermission;
    }
}
