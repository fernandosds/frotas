<?php


namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{

    /**
     * UserService constructor.
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
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

        if(isset($request->password)) {
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
        }else{
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
            $email = $this->user->getUserByEmail($email);

            // Cria uma senha aleatória com 6 dígitos

            // Usa o Hash::make pra criptografar a senha e fazer o update no banco

            // Envia a senha sem criptografia pro usuario por email

            

            //$this->userService->update($request, $request->id);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }

        //return
    }
}
