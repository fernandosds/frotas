<?php

namespace App\Services\Iscas;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Iscas\TrackerRepository;

class TrackerService
{

    protected $trackerRepository;

    /**
     * TrackerService constructor.
     * @param TrackerRepository $trackerRepository
     */
    public function __construct(TrackerRepository $trackerRepository)
    {
        $this->trackerRepository = $trackerRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {

        $boarding = $this->trackerRepository->create($request->all());
        return $boarding;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $tracker = $this->trackerRepository->update($id, $request->all());
        return $tracker;
    }


    /**
     * @param Int $id
     * @return bool
     */
    public function show(Int $id)
    {

        return $this->trackerRepository->find($id);
    }

    /**
     * @param Int $id
     * @return mixed|void
     */
    public function findTrackerByModel($tracker)
    {
        $trackerModel =  $this->trackerRepository->findTrackerByModel($tracker);
        return $trackerModel;
    }

    /**
     * @param array $array
     * @return mixed
     */
    public function saveTracker(array $array)
    {
        $arr_insert = [];
        foreach ($array[0] as $item) {
            if ($this->trackerRepository->exists(trim($item[0])) == 0) {

                if ($item[0] != "") {
                    $arr_insert[] = [
                        'model' => trim($item[0]),
                        'uniqid' => md5(uniqid(""))
                    ];
                }
            }
        }
        $device = DB::table('trackers')->insert($arr_insert);
        return ($device) ? $arr_insert : abort(404);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function attachDevices(Int $id, $object)
    {
        return $this->trackerRepository->attachDevices($object);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function filterByContractDevice($contract_devices)
    {
        return $this->trackerRepository->filterByContractDevice($contract_devices);
    }
}
