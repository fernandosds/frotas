<?php


namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
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

        // $dados = $request->all();
        $dados = $request->all();

        return $this->user->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {

        $request->merge(['password' => Hash::make($request->password)]);

        try{
            $user = $this->user->create($request->all());

            return ($user) ? ['status' => 'success', 200] : ['status' => 'error', 404];
        }catch (\Exception $e){
            return response()->json([
                'Sucesso' => 'false',
                'Message' => 'Erro ao processar informação: '.$e->getMessage()
            ],400);
        }





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
        $user = $this->user->update($id, $request->all());

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
}
