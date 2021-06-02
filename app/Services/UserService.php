<?php


namespace App\Services;

use App\Http\Controllers\HomeController;
use App\Mail\QRCodeMail;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Mail\ResetEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;

class UserService
{
    private $sendEmailResetPassword;
    private $userRepository;
    private $apiUserService;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param ResetEmail $sendEmailResetPassword
     */
    public function __construct(UserRepository $userRepository, ResetEmail $sendEmailResetPassword, ApiUserService $apiUserService)
    {
        $this->userRepository = $userRepository;
        $this->sendEmailResetPassword = $sendEmailResetPassword;
        $this->apiUserService = $apiUserService;
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

        if (Auth::user()->type == "ext") {
            return $this->userRepository->paginate($limit, Auth::user()->customer_id);
        }

        return $this->userRepository->paginate($limit, Auth::user()->customer_id);
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

        if ($request->customer_id == 1) {
            $request->merge([
                'type' => "sat",
            ]);
        } else {
            $request->merge([
                'type' => "ext",
            ]);
        }

        if (Auth::user()->type == "ext") {
            $request->merge([
                'type' => "ext",
                'customer_id' => Auth::user()->customer_id
            ]);
        }

        if (isset($request->password)) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        // New Secret
        $this->checkValidationToken($request);

        $user = $this->userRepository->create($request->all());

        // QRCode
        if ($request->required_validation == 1) {
            Mail::to($request->email)->send(new QRCodeMail($user, $this->apiUserService));
        }
        return $user;
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
            $this->checkValidationToken($request);
            return  $this->userRepository->update($id, $request->all());
        }
        $this->checkValidationToken($request);
        return $this->userRepository->update($id, $request->except('password'));
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

        try {
            Mail::to($user->email)->send(new ResetEmail($user));
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param Int $id
     * @return bool
     */
    private function accessDenied(Int $id)
    {

        if (Auth::user()->type == "ext") {
            $user = $this->userRepository->find($id);
            if (Auth::user()->customer_id != $user->customer_id) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param Int $id
     * @return bool
     */
    private function checkValidationToken(Request $request)
    {
        $secret['secret'] = null;
        if ($request->required_validation == 1) {
            $secret = $this->apiUserService->newSecret();
        }
        $request->merge(['validation_token' => $secret['secret']]);
        return true;
    }
}
