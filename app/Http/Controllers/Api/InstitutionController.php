<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Permissions;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Imports\InstitutionImport;
use App\Models\Institution;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class InstitutionController extends ApiController
{
    public function importFromExcel(Request $request)
    {
        $validationResult = $this->apiValidator($request, [
            'institutions' => 'required|file|mimes:xlsx',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            Excel::import(new InstitutionImport, $request->file('institutions'));
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => 'Okulları içeri aktarma başarılı.'
            ]);
        } catch (Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function create(Request $request)
    {
        $validationResult = $this->apiValidator($request, [
            'district_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'e_mail' => 'required',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $institution = new Institution($request->all());
            $institution->save();
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => 'Okul kaydı başarılı.'
            ]);
        } catch (Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function update(Request $request, $id)
    {
        $validationResult = $this->apiValidator($request, [
            'institutions' => 'required|file|mimes:xlsx',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $institution = Institution::find($id);
            $institution->fill($request->all());
            $institution->save();
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => 'Okul güncelleme başarılı.'
            ]);
        } catch (Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function delete(Request $request, $id)
    {

    }

    public function searchBy(Request $request): JsonResponse
    {
        $user = Auth::user();
        // Query taslağı oluşturuluyor
        $query = Institution::selectRaw('id, CONCAT(id, "-", name) as name');
        if ($user && $user->can(Permissions::INSTITUTION_LIST_LEVEL_3)) {
            if (!($request->has('content')
                && $request->has('district_id'))) {
                return response()->json([
                    ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
                    ResponseKeys::MESSAGE => 'Parametre gönderilmemiş!'
                ], 400);
            }
            $content = $request->get('content');
            $query->where('district_id', $request->get('district_id'));
            $query->where('name', 'like', '%' . $content . '%')
                ->orWhere('id', 'like', $content . '%');
            return response()->json($query->get());
        }
        // Burada else if bloğuna gerek yok çünkü yukarıda if içine girerse
        // fonk return ediliyor aşağı inmiyor akış
        if ($user->can(Permissions::INSTITUTION_LIST_LEVEL_2)) {
            if (!$request->has('content')) {
                return response()->json([
                    ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
                    ResponseKeys::MESSAGE => 'Parametre gönderilmemiş!'
                ], 400);
            }
            $content = $request->get('content');
            $query->where('district_id', $user->institution()->district_id);
            $query->where('name', 'like', '%' . $content . '%')
                ->orWhere('id', 'like', $content . '%');
            return response()->json($query->get());
        }

        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
            ResponseKeys::MESSAGE => 'Yetkisiz istek!'
        ], 400);
    }

    public function get($id): JsonResponse {
        $user = Auth::user();
        // Query taslağı oluşturuluyor
        $query = Institution::selectRaw('id, CONCAT(id, "-", name) as name');
        if ($user && $user->can(Permissions::INSTITUTION_LIST_LEVEL_3)) {
            if ($id != -1) { $query->where('district_id', $id); } // hepsini seçebiliriz id -1 ise çok iyi bir pratik değil ama refaktör edilebilir
            return response()->json($query->get());
        }
        // Burada else if bloğuna gerek yok çünkü yukarıda if içine girerse
        // fonk return ediliyor aşağı inmiyor akış
        if ($user->can(Permissions::INSTITUTION_LIST_LEVEL_2)) {
            $query->where('district_id', $user->institution()->district_id);
            return response()->json($query->get());
        }

        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
            ResponseKeys::MESSAGE => 'Yetkisiz istek!'
        ], 400);
    }

    public function getTable(Request $request): JsonResponse
    {
        $query = Institution::with('district');
        $user = Auth::user();

        // Yetki 3. seviye ise gönderilen veri içinde district id yok ise tümü ilçelerdeki kurumlar listelenir
        if($user && $user->can(Permissions::INSTITUTION_LIST_LEVEL_3)) {
            if ($request->has('district_id') && !is_null($request->input('district_id'))) {
                $query->where('district_id', '=', $request->input('district_id'));
            }
        }
        else if ($user->can(Permissions::INSTITUTION_LIST_LEVEL_2) && !$user->can(Permissions::INSTITUTION_LIST_LEVEL_3)) {
            $query->where('ogs_districts.district_id', '=', $user->institution()->district_id);
        }

        return Datatables::eloquent($query)
            ->toJson();
    }
}