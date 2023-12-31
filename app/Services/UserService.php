<?php


namespace App\Services;

use App\Http\Controllers\HomeController;
use App\Mail\QRCodeMail;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Mail\ResetEmail;
use Illuminate\Support\Facades\Route;
use App\Repositories\LogRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;

class UserService
{
    private $sendEmailResetPassword;
    private $userRepository;
    private $apiUserService;
    private $log;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param ResetEmail $sendEmailResetPassword
     */
    public function __construct(UserRepository $userRepository, ResetEmail $sendEmailResetPassword, ApiUserService $apiUserService, LogRepository $log)
    {
        $this->userRepository = $userRepository;
        $this->sendEmailResetPassword = $sendEmailResetPassword;
        $this->apiUserService = $apiUserService;
        $this->log = $log;
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
    public function paginate(Int $limit = 120)
    {

        if (Auth::user()->type == "sat") {
            return $this->userRepository->paginate($limit);
        }

        return $this->userRepository->paginate($limit, Auth::user()->customer_id);
    }

    public function getRemoveUsers($removeUser){
        return $this->userRepository->getRemoveUsers($removeUser);
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

        if (Auth::user()->type == "ext") {
            $request->merge([
                'type' => "ext",
                'customer_id' => Auth::user()->customer_id
            ]);
        }

        if (Auth::user()->type == "fle") {
            $request->merge([
                'type' => "fle",
                'customer_id' => Auth::user()->customer_id,
                'required_validation' => 0
            ]);
        }

        if (Auth::user()->type == "gfl") {
            $request->merge([
                'type' => "gfl",
                'customer_id' => Auth::user()->customer_id,
                'required_validation' => 0
            ]);
        }


        if (isset($request->password)) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        // New Secret
        $this->checkValidationToken($request);

        $this->log->saveLog(strval(Auth::user()->name), 'Cadastrou o usuario: ' . strval($request->name));


        saveLog(['value' => $request['name'], 'type' => 'Cadastrou_usuario', 'local' => 'UserService', 'funcao' => 'save']);

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

            if (Route::currentRouteName() != "profiles.update") {
                $this->checkTokenUpdate($request);
            }

            $this->log->saveLog(strval(Auth::user()->name), 'Atualizou a senha do usuario: ' . strval($request->name));
            saveLog(['value' => $request['name'], 'type' => 'Atualizou_a_senha_do_usuario', 'local' => 'UserService', 'funcao' => 'update']);
            return  $this->userRepository->update($id, $request->all());
        }

        $this->log->saveLog(strval(Auth::user()->name), 'Atualizou os dados cadastrais do usuario: ' . strval($request->name));
        saveLog(['value' => $request['name'], 'type' => 'Atualizou_os_dados_cadastrais_do_usuario', 'local' => 'UserService', 'funcao' => 'update']);

        if (Route::currentRouteName() != "profiles.update") {
            $this->checkTokenUpdate($request);
        }

        return $this->userRepository->update($id, $request->except('password'));
    }

    /**
     * @param Int $id
     * @return mixed|void
     */
    public function show(Int $id)
    {
        $user =  $this->userRepository->find($id);

        $this->log->saveLog(strval(Auth::user()->name), 'Monitorou o usuario: ' . strval($user->name));
        saveLog(['value' => $user->name, 'type' => 'Monitorou_o_usuario', 'local' => 'UserService', 'funcao' => 'show']);

        return ($user) ? $user : abort(404);
    }

    /**
     * @param Int $id
     * @return bool
     */
    public function destroy(Int $id)
    {
        $customer = $this->userRepository->find($id);

        $this->log->saveLog(strval(Auth::user()->name), 'Deletou o usuario: ' . strval($customer['name']));
        saveLog(['value' => $customer['name'], 'type' => 'Deletou_o_usuario', 'local' => 'UserService', 'funcao' => 'destroy']);

        return $this->userRepository->delete($id);
    }

    /**
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
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateUserAccess(Request $request, $id)
    {
        unset($request["_token"], $request["id"]);
        $userAccessRepository = $this->userRepository->updateUserAccess($id, $request->all());
        return $userAccessRepository;
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
            //Mail::to($request->email)->send(new QRCodeMail($request->id, $this->apiUserService));
        }
        $request->merge(['validation_token' => $secret['secret']]);
        return true;
    }

    /**
     * @param Int $id
     * @return bool
     */
    private function checkTokenUpdate(Request $request)
    {
        $user = $this->userRepository->find($request->id);

        if ($request->required_validation == 0) {
            $secret['secret'] = null;
            $request->merge(['validation_token' => $secret['secret']]);
        }

        if ($request->required_validation == 1 &&  $user->validation_token == null) {
            $secret = $this->apiUserService->newSecret();
            $request->merge(['validation_token' => $secret['secret']]);
            //Mail::to($request->email)->send(new QRCodeMail($user, $this->apiUserService));
        }
        return true;
    }
}