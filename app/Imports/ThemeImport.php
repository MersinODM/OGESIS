<?php

namespace App\Imports;

use App\Models\ActivityTheme;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ThemeImport implements ToCollection, WithHeadingRow
{
    public function chunkSize(): int
    {
        return 500;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $explodedStrings = Str::of($row['kod'])->explode('.');
            if ($explodedStrings && $explodedStrings->count() >= 2) {
                // ilk parent'ı bulsak yeterli ağaç yapısına benzer bir durum söz konusu değil temalarda
                $parentId = ActivityTheme::where('code', $explodedStrings[0])->value('id');
                ActivityTheme::create([
                    'code' => $row['kod'],
                    'name' => $row['baslik'],
                    'description' => $row['aciklama'],
                    'parent_id' => $parentId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            } else {
                ActivityTheme::create([
                    'code' => $row['kod'],
                    'name' => $row['baslik'],
                    'description' => $row['aciklama'],
                ]);
            }
        }
    }
}