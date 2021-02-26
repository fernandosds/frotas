<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 12:25
 */

namespace App\Services\Iscas;
use Illuminate\Http\Request;


use App\Repositories\Iscas\BoardingRepository;

class BoardingService
{

    protected $boardingRepository;

    /**
     * BoardingService constructor.
     * @param BoardingRepository $boardingRepository
     */
    public function __construct(BoardingRepository $boardingRepository)
    {
        $this->boardingRepository = $boardingRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {

        $boarding = $this->boardingRepository->create($request->all());
        return $boarding;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {

        $boarding = $this->boardingRepository->update($id, $request->all());
        return $boarding;
    
    }

    /**
     * @return mixed
     */
    public function getAllActive()
    {
        return $this->boardingRepository->getAllActive();
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginateFinished(Int $limit = 15)
    {
        return $this->boardingRepository->paginateFinished($limit);
    }

    /**
     * @param Int $id
     * @return bool
     */
    public function finish(Int $id)
    {
        return $this->boardingRepository->finish($id);
    }

    /**
     * @param Int $id
     * @return bool
     */
    public function show(Int $id)
    {

        return $this->boardingRepository->find($id);
    }

    /**
     * @return mixed
     */
    public function getAllPairActive()
    {
        return $this->boardingRepository->getAllPairActive();
    }

    /**
     * @param Int $id
     * @return mixed
     */
    public function getCurrentBoardingByDeviceId(Int $id)
    {
        return $this->boardingRepository->getCurrentBoardingByDeviceId($id);
    }

    /**
     * @param String $device
     * @return mixed
     */
    public function getCurrentBoardingByDevice(String $device)
    {
        return $this->boardingRepository->getCurrentBoardingByDevice($device);
    }

    /**
     *
     */
    public function autoFinatlizeBoardings()
    {
        return $this->boardingRepository->autoFinatlizeBoardings();
    }


}