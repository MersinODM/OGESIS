<?php

namespace App\Imports;

use App\Models\Lesson;
use App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BranchImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return new Lesson([
            'name'    => $row['brans'],
            'levels'    => $row['seviye']
        ]);
    }
}