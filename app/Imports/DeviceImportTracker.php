<?php

namespace App\Imports;

use App\Models\Tracker;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class DeviceImportTracker implements ToModel
{

    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {

        return new Tracker([
            'model'             => $row[0],
            'uniqid'            => md5(uniqid("_sat_"))
        ]);
    }
}
