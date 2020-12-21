<?php


namespace App\Services;

use App\Repositories\AccommodationLocationsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccommodationLocationsService
{
    public function __construct(AccommodationLocationsRepository $accommodationLocation)
    {
        $this->accommodationLocation = $accommodationLocation;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->accommodationLocation->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->accommodationLocation->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $dados = $request->all();

        return $this->accommodationLocation->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $accommodationLocation = $this->accommodationLocation->create($request->all());

        return $accommodationLocation;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $accommodationLocation = $this->accommodationLocation->update($id, $request->all());

        return $accommodationLocation;
    }



    public function show(Int $id)
    {

        $accommodationLocation =  $this->accommodationLocation->find($id);

        return ($accommodationLocation) ? $accommodationLocation : abort(404);
    }


    /**
     * @param Int $id
     */
    public function destroy(Int $id)
    {

        return $this->accommodationLocation->delete($id);
    }

    public function edit($id)
    {
        return $this->accommodationLocation->find($id);
    }

    /**
     * @return mixed
     */
    public function search()
    {
        return $this->accommodationLocation->search();
    }
}
