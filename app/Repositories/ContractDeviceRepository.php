<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 20/01/2021
 * Time: 17:33
 */

namespace App\Repositories;

use App\Models\ContractDevice;

class ContractDeviceRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param ContractDevice $model
     */
    public function __construct(ContractDevice $model)
    {
        $this->model = $model;
    }

    /**
     * @param Int $contract_id
     * @return mixed
     */
    public function deleteByContractId(Int $contract_id)
    {
        return $this->model->where('contract_id', $contract_id)->delete();
    }
}