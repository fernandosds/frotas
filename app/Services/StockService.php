<?php


namespace App\Services;

use App\Repositories\StockRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StockService
{
    public function __construct(StockRepository $stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->stock->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->stock->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $dados = $request->all();

        return $this->stock->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $stock = $this->stock->create($request->all());

        return $stock;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $stock = $this->stock->update($id, $request->all());

        return $stock;
    }



    public function show(Int $id)
    {

        $stock =  $this->stock->find($id);

        return ($stock) ? $stock : abort(404);
    }


    /**
     * @param Int $id
     */
    public function destroy(Int $id)
    {

        return $this->stock->delete($id);
    }

    public function edit($id)
    {
        return $this->stock->find($id);
    }
}
