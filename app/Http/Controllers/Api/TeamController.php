<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Permissions;
use App\Http\Controllers\ApiController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Utils\{ResponseCodes, ResponseKeys};
use App\Models\{Teacher, Team};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB};
use Yajra\DataTables\Facades\DataTables;

class TeamController extends ApiController
{
    /*
     *
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->can([Permissions::TEAM_CREATE_LEVEL_3, Permissions::TEAM_CREATE_LEVEL_2])) {
            $validationResult = $this->apiValidator($request, [
                'institution_id' => 'required',
                'name' => 'required',
                'teachers' => 'required|array|min:2'
            ]);
        } else if($user && $user->can(Permissions::TEAM_CREATE_LEVEL_1)) {
            $validationResult = $this->apiValidator($request, [
                'name' => 'required',
                'teachers' => 'required|array|min:2'
            ]);
        } else {
            return $this->unauthorized();
        }

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $team = new Team([
                'name' => $request->input('name'),
                'institution_id' => $request->has('institution_id') ? $request->input('institution_id') : $user->institution_id,
            ]);
            $team->save();
            // Oluşturduğumuz takıma öğretmenleri atıyoruz
            $team->teachers()->attach($request->get('teachers'));
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => 'Takım kayıt işlemi başarılı.'
            ]);
        } catch (Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $validationResult = null;
        if ($user && $user->can('team.create.admin')) {
            $validationResult = $this->apiValidator($request, [
                'plan_id' => 'required',
                'institution_id' => 'required',
                'team_name' => 'required',
//            'phone' => 'required',
//            'email' => 'required',
            ]);
        } else if ($user && $user->can('team.create.manager')) {
            $validationResult = $this->apiValidator($request, [
                'plan_id' => 'required',
                'team_name' => 'required',
//            'phone' => 'required',
//            'email' => 'required',
            ]);
        }

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $team = Team::find($id);
            $team->fill($request->all());
            $team->save();
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => 'Takım güncelleme işlemi başarılı.'
            ]);
        } catch (Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function delete(Request $request)
    {

    }

    /*
     * Tüm öğretmenleri getiren api endpoint
     */
    public function get($district_id, $institution_id): JsonResponse
    {
        $user = Auth::user();
        if ($user && $user->cannot('team.list.*')) {
            return $this->unauthorized();
        }
        $query = Team::with(['teachers:id,name'])
            ->select('id', 'institution_id', 'name');
        if ($user->can(Permissions::TEAM_LIST_LEVEL_3)) {
            $query->where('institution_id', $institution_id)
                ->whereHas('institution', static function (Builder $q) use ($district_id) {
                    $q->where('district_id', $district_id);
                });
            return response()->json($query->get());
        }
        if ($user->can(Permissions::TEAM_LIST_LEVEL_2)) {
            $query->where('institution_id', $institution_id)
                ->whereHas('institution', static function (Builder $q) use ($user) {
                    $q->where('district_id', $user->institution()->district_id);
                });
            return response()->json($query->get());
        }
        if ($user->can(Permissions::TEAM_LIST_LEVEL_1)) {
            $query->where('institution_id', $user->institution_id)
                ->whereHas('institution', static function (Builder $q) use ($user) {
                    $q->where('district_id', $user->institution()->district_id);
                });
            return response()->json($query->get());
        }
        return $this->unauthorized();
    }

    public function getTable(Request $request): JsonResponse
    {
        $query = Team::with('institution:id,district_id,name', 'institution.district:id,name')
        ->select('id', 'name', 'institution_id');
        $user = Auth::user();

        // Yetki 3. seviye ise gönderilen veri içinde district id yok ise tümü ilçelerdeki kurumlar listelenir
        if($user && $user->can(Permissions::TEAM_LIST_LEVEL_3)) {
            if ($request->has('district_id') && !is_null($request->input('district_id'))) {
                $query->whereRelation('institution', 'district_id', '=', $request->input('district_id'));
            }
            if ($request->has('institution_id') && !is_null($request->input('institution_id'))) {
                $query->where('institution_id', '=', $request->input('institution_id'));
            }
            return Datatables::eloquent($query)
                ->toJson();
        }

        if ($user->can(Permissions::TEAM_LIST_LEVEL_2) && $user->cannot(Permissions::TEAM_LIST_LEVEL_3)) {
            $query->whereRelation('institution', 'district_id', '=',  $user->institution()->district_id);
            if ($request->has('institution_id') && !is_null($request->input('institution_id'))) {
                $query->where('institution_id', '=', $request->input('institution_id'));
            }
            return Datatables::eloquent($query)
                ->toJson();
        }

        if ($user->cannot([Permissions::TEAM_LIST_LEVEL_3, Permissions::TEAM_LIST_LEVEL_2]) && $user->can(Permissions::TEAM_LIST_LEVEL_1)) {
            $query->where('institution_id', '=', $user->institution_id);
            return Datatables::eloquent($query)
                ->toJson();
        }
        return $this->unauthorized();
    }
}