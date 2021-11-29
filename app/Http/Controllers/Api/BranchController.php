<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends ApiController
{
    public function create(Request $request) {

    }

    public function update(Request $request) {

    }

    public function delete(Request $request) {

    }

    public function searchBy(Request $request) {
        if ($request->has('content')) {
            $content = $request->get('content');
            $results = Branch::where('name', 'like', '%' . $content . '%')
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