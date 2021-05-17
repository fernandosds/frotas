<?php


namespace App\Services;


use App\Repositories\UserAccessRepository;
use Illuminate\Http\Request;


class UserAccessService
{
    private $userAccessRepository;


    /**
     * UserService constructor.
     * @param UserAccessRepository $userRepository
     * 
     */
    public function __construct(UserAccessRepository $userAccessRepository)
    {

        $this->userAccessRepository  = $userAccessRepository;
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

    
}
