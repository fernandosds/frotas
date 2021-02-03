<?php


namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Mail\ResetEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private $sendEmailResetPassword;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param ResetEmail $sendEmailResetPassword
     */
    public function __construct(UserRepository $userRepository, ResetEmail $sendEmailResetPassword)
    {
        $this->userRepository = $userRepository;
        $this->sendEmailResetPassword = $sendEmailResetPassword;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->userRepository->all();
    }

    /**
     * @return mixed
     */
    public function getAllAdmins()
    {
        return $this->userRepository->getAllAdmins();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->userRepository->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {

        $dados = $request->all();

        return $this->userRepository->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {

        if (isset($request->password)) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        return $this->userRepository->create($request->all());
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {

        if (isset($request->password)) {
            $request->merge(['password' => Hash::make($request->password)]);
            $user = $this->userRepository->update($id, $request->all());
        } else {
            $user = $this->userRepository->update($id, $request->except('password'));
        }


        return $user;
    }

    /**
     * @param Int $id
     * @return mixed|void
     */
    public function show(Int $id)
    {

        $user =  $this->userRepository->find($id);

        return ($user) ? $user : abort(404);
    }


    /**
     * @param Int $id
     * @return bool
     */
    public function destroy(Int $id)
    {

        return $this->userRepository->delete($id);
    }

    /**]
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * @param $email
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword($email)
    {

        $user = $this->userRepository->getUserByEmail($email);

        Mail::to($user->email)->send(new ResetEmail($user));

        return response()->json(['status' => 'success'], 200);

    }

}
