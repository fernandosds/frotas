<?php


namespace App\Services;

use App\Repositories\LureRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LureService
{
    public function __construct(LureRepository $lure)
    {
        $this->lure = $lure;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->lure->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->lure->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $dados = $request->all();

        return $this->lure->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $lure = $this->lure->create($request->all());

        return $lure;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $lure = $this->customer->update($id, $request->all());

        return $lure;
    }



    public function show(Int $id)
    {

        $lure =  $this->lure->find($id);

        return ($lure) ? $lure : abort(404);
    }


    /**
     * @param Int $id
     */
    public function destroy(Int $id)
    {

        return $this->lure->delete($id);
    }

    public function edit($id)
    {
        return $this->lure->find($id);
    }
}
