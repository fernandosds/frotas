<?php


namespace App\Services;

use App\Repositories\TechnologieRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TechnologieService
{
    public function __construct(TechnologieRepository $technologie)
    {
        $this->technologie = $technologie;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->technologie->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->technologie->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $dados = $request->all();

        return $this->technologie->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $technologie = $this->technologie->create($request->all());

        return $technologie;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $technologie = $this->technologie->update($id, $request->all());

        return $technologie;
    }



    public function show(Int $id)
    {

        $technologie =  $this->technologie->find($id);

        return ($technologie) ? $technologie : abort(404);
    }


    /**
     * @param Int $id
     */
    public function destroy(Int $id)
    {

        return $this->technologie->delete($id);
    }

    public function edit($id)
    {
        return $this->technologie->find($id);
    }
}
