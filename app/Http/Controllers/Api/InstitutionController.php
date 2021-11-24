<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Imports\InstitutionImport;
use App\Imports\MultipleImport;
use App\Models\Institution;
use Exception;
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

    public function searchBy(Request $request)
    {
        // Query taslağı oluşturuluyor
        $query = Institution::selectRaw('id, CONCAT(id, "-", name) as name');
        // Querystring'de content var mı diye bakılıyor yoksa bad request geri dönyor
        if ($request->has('content')) {
            // Querystring'de district_id(ilçe id) var mı diye bakılıyor yoksa sadece iceriğe göre arama yapılıyor
            if($request->has('district_id')){
                $query->where('district_id', $request->get('district_id'));
            }
            $content = $request->get('content');
            $query->where('name', 'like', '%' . $content . '%')
                ->orWhere('id', 'like', $content . '%');
            return response()->json($query->get());
        }
        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
            ResponseKeys::MESSAGE => 'Parametre gönderilmemiş!'
        ], 400);
    }

    public function getTable(Request $request)
    {
        $query = Institution::with('district');
        $user = Auth::user();

        // TODO refaktör gerekebilir
        // Kullanıcı 2 seviye ise yani ilçe Mem kullanıcısı ise sadece kendi ilçesini listeleyebilsin
        if ($user && $user->can('institution.list.level2') && !$user->can('institution.list.level3')) {
            $query->where('ogs_districts.district_id', '=', $user->institution()->district_id);
        }

        if ($request->has('district_id') && !is_null($request->input('district_id'))) {
            $query->where('district_id', '=', $request->input('district_id'));
        }

        return Datatables::eloquent($query)
            ->make(true);
    }
}