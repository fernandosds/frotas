<?php


namespace App\Services;

use App\Repositories\TypeOfLoadRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TypeOfLoadService
{
    public function __construct(TypeOfLoadRepository $typeOfLoad)
    {
        $this->typeOfLoad = $typeOfLoad;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->typeOfLoad->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->typeOfLoad->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $dados = $request->all();

        return $this->typeOfLoad->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $typeOfLoad = $this->typeOfLoad->create($request->all());

        return $typeOfLoad;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $typeOfLoad = $this->typeOfLoad->update($id, $request->all());

        return $typeOfLoad;
    }



    public function show(Int $id)
    {

        $typeOfLoad =  $this->typeOfLoad->find($id);

        return ($typeOfLoad) ? $typeOfLoad : abort(404);
    }


    /**
     * @param Int $id
     */
    public function destroy(Int $id)
    {

        return $this->typeOfLoad->delete($id);
    }

    public function edit($id)
    {
        return $this->typeOfLoad->find($id);
    }
}
