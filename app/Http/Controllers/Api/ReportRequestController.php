<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Institution;
use App\Models\ReportRequest;
use App\Traits\RandomCodeGenerator;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Utils\{ResponseCodes, ResponseKeys};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportRequestController extends ApiController
{
    use RandomCodeGenerator;

    public function create(Request $request) {
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

        if($districts->contains(-1) && $institutions->contains(-1)) {
            $institutions = Institution::select('id')->get()->pluck('id');
        } else if (!$districts->contains(-1) && $institutions->contains(-1)) {
            $institutions = Institution::select('id')->whereIn('district_id', $districts)->get()->pluck('id');
        }

    try {
        $code =  $this->getRandomCode();
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
}