<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Permissions;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Activity;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

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

    public function getTable(Request $request) {
        $query = Activity::with('theme:id,name', 'institution:id,name', 'type:id,name')
        ->with(['partners' => static function ($query) {
           $query->select('id','name');
        }]);
        $user = Auth::user();

        // TODO refaktör gerekebilir
        // Kullanıcı 2i seviye(leve2) ise yani ilçe Mem kullanıcısı ise sadece kendi ilçesini listeleyebilsin
        // Yetkiye en üst seviyeden başlayarak bakabiliriz böylece üst else if yapısı amacına uygun çalışmış olur
        if ($user && $user->can(Permissions::LEVEL_3)) {
            $this->checkDistrict($request, $query);
            $this->checkInstitution($request, $query);
        } else if ($user && $user->can(Permissions::LEVEL_2)) {
            $query->whereHas('institution', static function (Builder $q) use ($user) {
                $q->where('district_id', $user->institution()->district_id);
            });
            $this->checkInstitution($request, $query);
        } else if ($user && $user->can(Permissions::LEVEL_1)) {
            $query->whereHas('institution', static function (Builder $q) use ($user) {
                $q->where('district_id', $user->institution()->district_id);
            });
            $query->where('institution_id', '=', $user->institution()->id);
        } else {
            return $this->unauthorized();
        }

        return Datatables::eloquent($query)
            ->toJson();
    }
}