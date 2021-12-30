<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Permissions;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Activity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ActivityController  extends ApiController
{
    public function create(Request $request) {
        $validationResult = $this->apiValidator($request, [
            'plan_id' => 'required',
            'institution_id' => Rule::requiredIf($request->user()->can([Permissions::ACTIVITY_CREATE_LEVEL_3, Permissions::ACTIVITY_CREATE_LEVEL_2])),
            'theme_id' => 'required',
            'title' => 'required',
            'planned_start_date' => 'required',
            'planned_end_date' => 'required',
            'description' => 'required|max:5000'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $activity = new Activity($request->all());
            // Okul kullanıcısı ise burada aktivite id otomatik kullanıcıdan gelecek
            if($request->user()->cannot([Permissions::ACTIVITY_CREATE_LEVEL_3, Permissions::ACTIVITY_CREATE_LEVEL_2])){
                $activity->institution_id = $request->user()->institution_id;
            }
            $activity->save();
            DB::commit();
            return response()->json([
               ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
               ResponseKeys::MESSAGE => 'Etkinlik kayıt işlemi başarılı.'
            ]);
        } catch(Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function update(Request $request, $id) {
        $validationResult = $this->apiValidator($request, [
            'plan_id' => 'required',
            'type' => 'required',
            'theme_id' => 'required',
            'title' => 'required',
            'interlocutor' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required|max:5000'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $activity = Activity::find($id);
            $activity->fill($request->all());
            $activity->save();
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => 'Etkinlik kayıt işlemi başarılı.'
            ]);
        } catch(Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function delete(Request $request) {
        // Gate::allows("can-delete-activity");
    }

    public function list(Request $request) {
        //TODO burada role ve okula görefarklı listeleme mantıkları eklenecek
    }
}