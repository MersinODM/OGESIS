<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeamController extends ApiController
{
    public function create(Request $request) {
        $user = Auth::user();
        $validationResult = null;
        if($user && $user->can('team.create.admin')) {
            $validationResult = $this->apiValidator($request, [
                'plan_id' => 'required',
                'institution_id' => 'required',
                'team_name' => 'required',
//            'phone' => 'required',
//            'email' => 'required',
            ]);
        }
        else if($user && $user->can('team.create.manager')) {
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
            $team = new Team($request->all());
            $team->save();
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => 'Takım kayıt işlemi başarılı.'
            ]);
        } catch(Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function update(Request $request, $id) {
        $user = Auth::user();
        $validationResult = null;
        if($user && $user->can('team.create.admin')) {
            $validationResult = $this->apiValidator($request, [
                'plan_id' => 'required',
                'institution_id' => 'required',
                'team_name' => 'required',
//            'phone' => 'required',
//            'email' => 'required',
            ]);
        }
        else if($user && $user->can('team.create.manager')) {
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
        } catch(Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function  delete(Request $request) {

    }

    public function list(Request $request) {

    }
}