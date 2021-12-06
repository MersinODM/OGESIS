<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\DevPlan;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeamController extends ApiController
{
    public function create(Request $request)
    {
        $user = Auth::user();
//        $validationResult = null;
//        if($user && $user->can('team.create.admin')) {
//            $validationResult = $this->apiValidator($request, [
//                'institution_id' => 'required',
//                'team_name' => 'required',
////            'phone' => 'required',
////            'email' => 'required',
//            ]);
//        }
//        else
//        if ($user && $user->can('team.create.manager')) {
            $validationResult = $this->apiValidator($request, [
                'name' => 'required',
                'teachers' => 'required|array|min:2'
//            'phone' => 'required',
//            'email' => 'required',
            ]);
//        }

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            $planId = DevPlan::where('is_open', true)
                ->where('institution_id', $user->institution_id)
                ->orderBy('created_at')
                ->select('id')->first();
            if (!$planId) {
                return response()->json([
                    ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
                    ResponseKeys::MESSAGE => 'Açık plan bulunamadı!'
                ], 400);
            }
            DB::beginTransaction();
            // En son aluşturulan açık plana atanıyor takım
            // TODO Her planda takımlar yeniden oluşturulmalı mı?
            $team = new Team(['name' => $request->input('name'), 'plan_id' => $planId]);
            $team->save();
            $team->teachers()->attach($request->input('teachers'));
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

    public function list(Request $request)
    {

    }
}