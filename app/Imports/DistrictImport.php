<?php

namespace App\Imports;

use App\Models\District;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\ToModel;

class DistrictImport implements ToModel
{
    public function model(array $row)
    {
        return new District([
            'name'    => $row[1],
            'province_id' => $row[2],
        ]);
    }
}