<?php

namespace App\Imports;

use App\Models\Province;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProvinceAndDistrictImport implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            0 => new ProvinceImport(),
            1 => new DistrictImport(),
        ];
    }
}