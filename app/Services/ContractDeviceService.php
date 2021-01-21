<?php


namespace App\Services;

use App\Repositories\ContractDeviceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ContractDeviceService
{
    public function __construct(ContractDeviceRepository $contractdevice)
    {
        $this->contractdevice = $contractdevice;
    }

    /**
     * @return mixed
     */
    public function findContractDevice($id)
    {
        return $this->contractdevice->findContractDevice($id);
    }
}
