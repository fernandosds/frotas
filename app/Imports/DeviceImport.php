<?php

namespace App\Imports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class DeviceImport implements ToModel
{

    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {

        return new Device([
            'model'             => $row[0],
            'technologie_id'    => $row[1],
            'uniqid'            => md5(uniqid("_sat_"))
        ]);

    }

}
