<?php

namespace App\Services\Iscas;

use Illuminate\Http\Request;


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

        return ($trackerModel) ? $trackerModel : abort(404);
    }
}
