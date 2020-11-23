<?php


namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @return mixed
     */
    public function all()
    {
        return resolve('App\Repositories\UserRepository')->all();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {

        $request->merge(['password' => Hash::make($request->password)]);
        $user = resolve('App\Repositories\UserRepository')->create($request->all());

        return $user;
    }


    public function show(Int $id)
    {

        $user = resolve('App\Repositories\UserRepository')->find($id);

        return ($user) ? $user : abort(404);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {

        if ($request->password) {
            $request->merge(['password' => Hash::make($request->password)]);
        }
        $user = resolve('App\Repositories\UserRepository')->update($id, $request->all());

        return $user;
    }

    /**
     * @param Int $id
     */
    public function delete(Int $id)
    {
        $user = resolve('App\Repositories\UserRepository')->findOrFail($id);

        return ($user) ? $user->delete() : abort(404);
    }
}
