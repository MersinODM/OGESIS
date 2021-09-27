<?php

namespace App\Imports;

use App\Models\District;
use App\Models\Province;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class ProvinceImport implements ToModel
{
    public function model(array $row): Province
    {
        return new Province([
            'id'  => $row[0],
            'code' => $row[0],
            'name' => $row[1]
        ]);
    }
}