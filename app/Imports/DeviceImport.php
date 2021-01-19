<?php

namespace App\Imports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class DeviceImport implements ToModel, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Device([
            'model'         => $row[0],
            'tecnology_id'  => $row[1],
            'uniqid'        => md5(uniqid("_sat_"))
        ]);

    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'model' => Rule::unique('devices', 'model'), // Table name, field in your db
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'model.unique' => 'Dispositivo já importado anteriormente',
        ];
    }
}
