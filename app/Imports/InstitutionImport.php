<?php

namespace App\Imports;

use App\Models\District;
use App\Models\Institution;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InstitutionImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Institution([
            'id'  => $row['kod'],
            'district_id' => District::whereRaw('LOWER(name) = LOWER(:district) and province_id=:code',
                ['district' => $row['ilce'], 'code' => $row['plaka']])->first()->id,
            'name' => $row['ad'],
            'phone'    => $row['telefon'],
            'address'    => $row['adres'],
            'email'    => $row['eposta'],
        ]);
    }
}