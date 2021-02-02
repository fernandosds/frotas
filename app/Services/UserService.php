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
     * @param UserRepository $user
     * @param ResetMail $sendEmailResetPassword
     * 
     */
    public function __construct(UserRepository $user, ResetEmail $sendEmailResetPassword)
    {
        $this->user = $user;
        $this->sendEmailResetPassword = $sendEmailResetPassword;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->user->all();
    }

    /**
     * @return mixed
     */
    public function getAllAdmins()
    {
        return $this->user->getAllAdmins();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->user->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {

        $dados = $request->all();

        return $this->user->create($dados)->orderBy('id')->get();
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

        return $this->user->create($request->all());
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
            $user = $this->user->update($id, $request->all());
        } else {
            $user = $this->user->update($id, $request->except('password'));
        }


        return $user;
    }



    public function show(Int $id)
    {

        $user =  $this->user->find($id);

        return ($user) ? $user : abort(404);
    }


    /**
     * @param Int $id
     */
    public function destroy(Int $id)
    {

        return $this->user->delete($id);
    }

    public function edit($id)
    {
        return $this->user->find($id);
    }

    public function resetPassword($email)
    {
        try {

            // Busca usuário filrando pelo email
            $user = $this->user->getUserByEmail($email);

            // Cria uma senha aleatória com 6 dígitos
            $newPassword = $this->generatePassword();

            // Usa o Hash::make pra criptografar a senha e fazer o update no banco
            $passwordHashed = Hash::make($newPassword);

            $user->password = $passwordHashed;

            $user->save();


            $newPassword = array(
                'newPassword' => $newPassword
            );

            // Envia a senha sem criptografia pro usuario por email (Criar função)
            $this->sendEmailResetPassword->build($newPassword);
            Mail::to($user->email)->send(new ResetEmail($user));

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }

        //return
    }

    function generatePassword($qtyCaraceters = 8)
    {

        $smallLetters = str_shuffle('abcdefghijklmnopqrstuvwxyz');

        $capitalLetters = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
        $numbers .= 1234567890;

        $specialCharacters = str_shuffle('!@#$%*-');

        $characters = $capitalLetters . $smallLetters . $numbers . $specialCharacters;

        $password = substr(str_shuffle($characters), 0, $qtyCaraceters);

        return $password;
    }
}
