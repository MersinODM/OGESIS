<?php

namespace App\Imports;

use App\Models\Branch;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BranchImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return new Branch([
            'name'    => $row['brans'],
            'levels'    => $row['seviye']
        ]);
    }
}