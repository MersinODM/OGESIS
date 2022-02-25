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
        $user = $request->user();

        $validationResult = $this->apiValidator($request, [
            'plan_id' => 'required',
            'institution_id' => Rule::requiredIf($user->can([Permissions::LEVEL_3, Permissions::LEVEL_2])),
            'theme_id' => 'required',
            'title' => 'required',
            'planned_start_date' => 'required|date',
            'planned_end_date' => 'required|date|after:planned_start_date',
            'description' => 'required|max:5000',
            'team_id' => 'required_if:isTeamSelected,true',
            'teachers' =>'required_if:isTeamSelected,false',
        ]);

        if ($validationResult) {
            return $this->validationResponse($validationResult);
        }

        try {
            DB::beginTransaction();
            $activity = new Activity($request->all());
            // Okul kullanıcısı ise burada aktivite id otomatik kullanıcıdan gelecek
            if($user->cannot([Permissions::LEVEL_3, Permissions::LEVEL_2])){
                $activity->institution_id = $request->user()->institution_id;
            }
            $activity->save();
            if (!$request->input('isTeamSelected')) {
                $activity->teachers()->attach($request->input('teachers'));
            }
            $activity->partners()->attach($request->input('partners'));
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
            return $this->validationResponse($validationResult);
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