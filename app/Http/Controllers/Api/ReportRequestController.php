<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Permissions;
use App\Http\Controllers\ApiController;
use App\Models\Institution;
use App\Models\ReportRequest;
use App\Traits\DistrictTableFilter;
use App\Traits\RandomCodeGenerator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Utils\{ResponseCodes, ResponseKeys};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportRequestController extends ApiController
{
    use RandomCodeGenerator;
    use DistrictTableFilter;

    public function create(Request $request)
    {
        $validationResult = $this->apiValidator($request, [
            'district_id' => 'required|min:1',
            'institution_id' => 'required|min:1',
            'plan_id' => 'required',
            'description' => 'required',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $districts = collect($request->get('district_id'));
        $institutions = collect($request->get('institution_id'));

        if ($districts->contains(-1) && $institutions->contains(-1)) {
            $institutions = Institution::select('id')->get()->pluck('id');
        } else if (!$districts->contains(-1) && $institutions->contains(-1)) {
            $institutions = Institution::select('id')->whereIn('district_id', $districts)->get()->pluck('id');
        }

        try {
            $code = $this->getRandomCode();
            DB::beginTransaction();
            foreach ($institutions as $inst) {
                $reportRequest = new ReportRequest([
                    'institution_id' => $inst,
                    'plan_id' => $request->get('plan_id'),
                    'description' => $request->get('description'),
                    'creator_id' => Auth::id(),
                    'code' => $code
                ]);
                $reportRequest->save();
            }
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

    public function getTable(Request $request): JsonResponse
    {
        $query = ReportRequest::with('institution:id,district_id,name', 'plan:id,name')
            ->select('ogs_report_requests.id', 'ogs_report_requests.code', 'ogs_report_requests.description', 'institution_id', 'plan_id', 'file_name');
        $user = Auth::user();
        // Plan id verilmişse buna göre süzdürme yapıyoruz bunu tüm seviyelerde yapabiliriz
        if ($request->has('plan_id') && !is_null($request->input('plan_id'))) {
            $query->where('plan_id', '=', $request->input('plan_id'));
        }

        // Yetki 3. seviye ise gönderilen veri içinde district id yok ise tümü ilçelerdeki kurumlar listelenir
        if($user && $user->can(Permissions::LEVEL_3)) {
            if ($request->has('district_id') && !is_null($request->input('district_id'))) {
                $query->whereRelation('institution', 'district_id', '=', $request->input('district_id'));
            }
            if ($request->has('institution_id') && !is_null($request->input('institution_id'))) {
                $query->where('institution_id', '=', $request->input('institution_id'));
            }
            return Datatables::eloquent($query)
                ->toJson();
        }

        if ($user->can(Permissions::LEVEL_2) && $user->cannot(Permissions::LEVEL_3)) {
            $query->whereRelation('institution', 'district_id', '=',  $user->institution()->district_id);
            if ($request->has('institution_id') && !is_null($request->input('institution_id'))) {
                $query->where('institution_id', '=', $request->input('institution_id'));
            }
            return Datatables::eloquent($query)
                ->toJson();
        }

        if ($user->cannot([Permissions::LEVEL_3, Permissions::LEVEL_2]) && $user->can(Permissions::LEVEL_1)) {
            $query->where('institution_id', '=', $user->institution_id);
            return Datatables::eloquent($query)
                ->toJson();
        }
        return $this->unauthorized();
    }
}