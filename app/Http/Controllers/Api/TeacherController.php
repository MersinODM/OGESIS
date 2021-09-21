<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Activity;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends ApiController
{

    public function create(Request $request) {


        //TODO  İnstitution için admin ve okul yetkilisi vfarklı girişler yapailşmeli
        $validationResult = $this->apiValidator($request, [
            'branch_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
//            'phone' => 'required',
//            'email' => 'required',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $teacher = new Teacher($request->all());
            $teacher->save();
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => 'Öğretmen kayıt işlemi başarılı.'
            ]);
        } catch(Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function update(Request $request) {

    }

    public function  delete(Request $request) {

    }

    public function listeleme(Request $request) {

    }

}