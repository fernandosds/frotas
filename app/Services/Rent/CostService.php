<?php


namespace App\Services\Rent;
use Illuminate\Http\Request;
use App\Repositories\Rent\CostRepository;


class CostService
{
    public function __construct(CostRepository $cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->cost->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->cost->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {

        // $dados = $request->all();
        $cost = $request->all();

        return $this->cost->create($cost)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $cost = $this->cost->create($request->all());

        return $cost;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $cost = $this->cost->update($id, $request->all());
        return $cost;
    }

    /**
     * @param Int $id
     * @return \Illuminate\Support\Collection|void
     */
    public function show(Int $id)
    {

        $cost =  $this->cost->show($id);

        return ($cost) ? $cost : abort(404);
    }


    /**
     * @param Int $id
     * @return bool
     */
    public function destroy(Int $id)
    {

        return $this->cost->delete($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        return $this->cost->find($id);
    }
}
