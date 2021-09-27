<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\District;

class DistrictController extends ApiController
{
    public function list() {
        $districts = District::where('province_id', 33)
            ->orderBy('name', 'asc')
            ->get();
        return response()->json($districts);
    }
}