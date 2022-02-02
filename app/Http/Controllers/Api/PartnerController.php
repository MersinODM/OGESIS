<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\{ResponseCodes, ResponseKeys};
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends ApiController
{
    public function searchBy(Request $request) {
        if ($request->has('content')) {
            $content = $request->get('content');
            $results = Partner::where('name', 'like', '%' . $content . '%')
                ->orWhere('code', 'like', $content . '%')
                ->select('id', 'name')
                ->get();
            return response()->json($results);
        }
        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
            ResponseKeys::MESSAGE => 'Parametre gönderilmemiş!'
        ], 400);
    }
}