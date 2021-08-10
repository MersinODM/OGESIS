<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\DevPlan;
use App\Policies\DevPlanPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends ApiController
{
    public function update($id, Request $request) {

        $validationResult = $this->apiValidator($request, [
            'description' => 'required',
//            'report_name' => 'required',
//            'report_file' => 'required|file|size:4096|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try{
            DB::BeginTransaction();
            $plan = DevPlan::find($id);
            $this->authorize('update', $plan);
            $plan->fill($request->all(["description"]));
            $plan->save();

            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Plan güncelleme işlemi başarılı."
            ]);
        }
        catch (\Illuminate\Auth\Access\AuthorizationException $ex) {
            DB::rollBack();
            return response()->json([
                    ResponseKeys::CODE => ResponseCodes::CODE_UNAUTHORIZED,
                    ResponseKeys::MESSAGE => 'Bu işlem için yetkiniz yok!'
                ]);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return $this->apiException($e);
        }
    }
}