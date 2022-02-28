<?php

namespace App\Traits;

use App\Helpers\Permissions;
use Yajra\DataTables\Facades\DataTables;

trait DistrictTableFilter
{
    public function districtFilter($user, $query, $request) {
        // Yetki 3. seviye ise gönderilen veri içinde district id yok ise tümü ilçelerdeki kurumlar listelenir
        if($user && $user->can(Permissions::LEVEL_3)) {
            if ($request->has('district_id') && !is_null($request->input('district_id'))) {
                $query->whereRelation('institution', 'district_id', '=', $request->input('district_id'));
            }
            if ($request->has('institution_id') && !is_null($request->input('institution_id'))) {
                $query->where('institution_id', '=', $request->input('institution_id'));
            }
            return Datatables::eloquent($query)
                ->toJson();
        }
        return false;
    }
}