<?php


namespace App\Services\Iscas;

use App\Repositories\Iscas\ContractDeviceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ContractDeviceService
{

    /**
     * ContractDeviceService constructor.
     * @param ContractDeviceRepository $contractdevice
     */
    public function __construct(ContractDeviceRepository $contractdevice)
    {
        $this->contractdevice = $contractdevice;
    }

    /**
     * @return mixed
     */
    public function show($id)
    {
        return $this->contractdevice->show($id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function setAttachStatus(Int $id)
    {
        return $this->contractdevice->update($id, ['status' => 1]);
    }

     /**
     * @param $id
     * @return bool
     */
    public function checkStatusContractDevice(Int $id)
    {
        return $this->contractdevice->checkStatusContractDevice($id);
    }

   
}
