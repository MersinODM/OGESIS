<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\DevPlan;
use App\Models\Institution;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends ApiController
{
    public function createAll(Request $request) {
        $validationResult = $this->apiValidator($request, [
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $devPlan = new DevPlan($request->all());
            $institutions = Institution::all();
            foreach ($institutions as $institution) {
                $devPlan->institution_id = $institution->id;
                $devPlan->is_open = true;
                $devPlan->save();
            }
            DB::commit();
            return  response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => $institutions->count()." adet okul için planlar başarıyla oluşturuldu."
            ]);
        }
        catch (Exception $exception) {
            DB::rollBack();
            return $this->apiException($exception);
        }
    }

    /**
     * @param int $count
     * @return JsonResponse
     */
    public function getLastPlans(int $count = 5): JsonResponse
    {
        $plans = DevPlan::select('id', 'name')
            ->where('is_open', true)
            ->take($count)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($plans);

    }
}