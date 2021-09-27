<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Teacher;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeamTeacherController extends ApiController
{
    public function addTeachersToTeam(Request $request, $team_id) {
        $user = Auth::user();
        $validationResult = null;
        if($user && $user->can('team.add-member.admin')) {
            $validationResult = $this->apiValidator($request, [
                'institution_id' => 'required',
                'members' => 'required|array|distinct|min:1',
            ]);
        }
        else if($user && $user->can('team.add-member.manager')) {
            $validationResult = $this->apiValidator($request, [
                'members' => 'required|array|distinct|min:1'
            ]);
        }

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $team = Team::find($team_id);
            $team->teachers()->attach($request->input('members'));
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => 'Öğretmen(ler) takıma eklendi.'
            ]);
        } catch(Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function removeTeachersFromTeam(Request $request, $team_id) {
        $user = Auth::user();
        $validationResult = null;
        if($user && $user->can('team.remove-member.admin')) {
            $validationResult = $this->apiValidator($request, [
                'institution_id' => 'required',
                'members' => 'required|array|distinct|min:1',
            ]);
        }
        else if($user && $user->can('team.remove-member.manager')) {
            $validationResult = $this->apiValidator($request, [
                'members' => 'required|array|distinct|min:1'
            ]);
        }

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $team = Team::find($team_id);
            $team->teachers()->detach($request->input('members'));
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => 'Öğretmen(ler) takımdan çıkarıldı.'
            ]);
        } catch(Exception $exception) {
            return $this->apiException($exception);
        }
    }
}