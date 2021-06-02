<?php


namespace App\Services\Fleets;
use Illuminate\Http\Request;
use App\Repositories\Fleets\DriverRepository;


class DriverService
{

    /**
     * DriverService constructor.
     * @param DriverRepository $driver
     */
    public function __construct(DriverRepository $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->car->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->driver->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {

        // $dados = $request->all();
        $driver = $request->all();

        return $this->car->create($driver)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $driver = $this->driver->create($request->all());

        return $driver;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $driver = $this->driver->update($id, $request->all());
        return $driver;
    }

    /**
     * @param Int $id
     * @return \Illuminate\Support\Collection|void
     */
    public function show(Int $id)
    {

        $driver =  $this->driver->show($id);

        return ($driver) ? $driver : abort(404);
    }


    /**
     * @param Int $id
     * @return bool
     */
    public function destroy(Int $id)
    {

        return $this->driver->delete($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        return $this->driver->find($id);
    }
}
