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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PlanController extends ApiController
{
    public function createAll(Request $request)
    {
        $validationResult = $this->apiValidator($request, [
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'required',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }
        $givenStartDate =  $request->input('start_date');
        $givenEndDate = $request->input('end_date');

        // Not aşağıda verilen tarihler için bir kapsama kontrol algoritması verilmiştir
        // Sol taraf daha küçük sağ taraf daha büyük tarih şeklinde yorumlanmalıdır.
        // GSD<--->GED Verilen başlangış tarihi verilen bitiş tarihinden büyük anlamına gelir
        // ÜStteki yaklaşıma göre büyülük küçüklük kontrolü ilşikisi aşağıda kurulmuştur.

        $isIntersect = DevPlan::query()
            ->where(static function ($query) use ($givenEndDate, $givenStartDate) {
                //     GSD<------>GED             Verilen başlangıç bitiş tarihleri
                // SD<--------------->ED          DB'deki olası balangıç bitiş tarihleri
                return $query->where('start_date', '<=', $givenStartDate)
                    ->where('end_date', '>=', $givenEndDate);
            })
            ->orWhere(static function ($query) use ($givenEndDate, $givenStartDate) {
                // GSD<------------->GED          Verilen başlangıç bitiş tarihleri
                //     SD<----->ED                DB'deki olası balangıç bitiş tarihleri
                return $query->where('start_date', '>=', $givenStartDate)
                    ->where('end_date', '<=', $givenEndDate);
            })
            ->orWhere(static function ($query) use ($givenEndDate, $givenStartDate) {
                //      GSD<-------->GED          Verilen başlangıç bitiş tarihleri
                // SD<--------->ED                DB'deki olası balangıç bitiş tarihleri
                return $query->where('start_date', '<=', $givenStartDate)
                    ->where('end_date', '>=', $givenStartDate)
                    ->where('end_date', '<=', $givenEndDate);
            })
            ->orWhere(static function ($query) use ($givenEndDate, $givenStartDate) {
                // GSD<-------->GED                Verilen başlangıç bitiş tarihleri
                //       SD<--------->ED           DB'deki olası balangıç bitiş tarihleri
                return $query->where('end_date', '>=', $givenEndDate )
                    ->where('start_date', '>=', $givenStartDate)
                    ->where('start_date', '<=', $givenEndDate);
            })->count('id') > 0;
        if ($isIntersect) {
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
                ResponseKeys::MESSAGE => 'Seçilen tarih aralığı içinde/kapsamında ya da kesişimibde halihazırda oluşturulmuş plan var!'
            ]);
        }

        try {
            DB::beginTransaction();
            $devPlan = new DevPlan($request->all());
            $devPlan->save();
            $devPlan->institutions()->attach($institutions = Institution::all('id'));
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => $institutions->count() . " adet okul için planlar başarıyla oluşturuldu."
            ]);
        } catch (Exception $exception) {
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