<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\ActivityTheme;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\NotImplementedException;

class ThemeController extends ApiController
{
    public function create(Request $request) {
        $validationResult = $this->apiValidator($request, [
            'name' => 'required',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $activityTheme = new ActivityTheme($request->all());
            $activityTheme->save();
            DB::commit();
            return response()->json([
               ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
               ResponseKeys::MESSAGE => "Tema kaydı başarılı."
            ]);
        }
        catch (Exception $exception) {
            DB::rollBack();
            return $this->apiException($exception);
        }
    }

    public function update(Request $request, $id) {
        $validationResult = $this->apiValidator($request, [
            'name' => 'required',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $activityTheme = ActivityTheme::find($id);
            $activityTheme->fill($request->all());
            $activityTheme->save();
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Tema güncelleme başarılı."
            ]);
        }
        catch (Exception $exception) {
            DB::rollBack();
            return $this->apiException($exception);
        }
    }

    public function delete(Request $request) {
        throw new NotImplementedException();
    }

    public function searchByName(Request $request) {
        $validationResult = $this->apiValidator($request, [
            'name' => 'required',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $name = $request->get('name');
        $themes = ActivityTheme::where('name', 'like', '%'.$name.'%')->get();
        return response()->json($themes);
    }
}