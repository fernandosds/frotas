<?php


namespace App\Services;

use App\Repositories\DeviceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeviceService
{
    public function __construct(DeviceRepository $device)
    {
        $this->device = $device;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->device->all();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->device->paginate($limit);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $dados = $request->all();

        return $this->device->create($dados)->orderBy('id')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $device = $this->device->create($request->all());

        return $device;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $device = $this->device->update($id, $request->all());

        return $device;
    }



    public function show(Int $id)
    {

        $device =  $this->device->find($id);

        return ($device) ? $device : abort(404);
    }


    /**
     * @param Int $id
     */
    public function destroy(Int $id)
    {

        return $this->device->delete($id);
    }

    public function edit($id)
    {
        return $this->device->find($id);
    }
}
