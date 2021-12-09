<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Activity;
use App\Models\Institution;
use App\Models\Teacher;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TeacherController extends ApiController
{
    public function create(Request $request)
    {
        $user = Auth::user();
        $validationResult = null;
        if ($user && $user->can('teacher.create.admin')) {
            $validationResult = $this->apiValidator($request, [
                'branch_id' => 'required',
                'institution_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
//            'phone' => 'required',
//            'email' => 'required',
            ]);
        } else if ($user && $user->can('teacher.create.manager')) {
            $validationResult = $this->apiValidator($request, [
                'branch_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
//            'phone' => 'required',
//            'email' => 'required',
            ]);
        }


        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $teacher = new Teacher($request->all());
            $teacher->save();
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => 'Öğretmen kayıt işlemi başarılı.'
            ]);
        } catch (Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $validationResult = null;
        if ($user && $user->can('teacher.update.admin')) {
            $validationResult = $this->apiValidator($request, [
                'branch_id' => 'required',
                'institution_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
//            'phone' => 'required',
//            'email' => 'required',
            ]);
        } else if ($user && $user->can('teacher.update.manager')) {
            $validationResult = $this->apiValidator($request, [
                'branch_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
//            'phone' => 'required',
//            'email' => 'required',
            ]);
        }

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $teacher = Teacher::find($id);
            $teacher->fill($request->all());
            $teacher->save();
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => 'Öğretmen güncelleme işlemi başarılı.'
            ]);
        } catch (Exception $exception) {
            return $this->apiException($exception);
        }
    }

    public function delete(Request $request)
    {

    }

    public function list(Request $request): JsonResponse
    {
        $user = Auth::user();
        $query = Teacher::with(['branch:id,name'])
            ->select('id', 'branch_id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'));

        if ($user && $user->can('teacher.list.level3')) {
            $validationResult = $this->apiValidator($request, [
                'district_id' => 'required',
                'institution_id' => 'required',
            ]);
            if ($validationResult) {
                return response()->json($validationResult, 422);
            }
            $query->where('institution_id', $request->query('institution_id'))
                ->where('district_id', $request->query('district_id'));
        } else if ($user && $user->can('teacher.list.level2')) {
            $validationResult = $this->apiValidator($request, [
                'institution_id' => 'required',
            ]);
            if ($validationResult) {
                return response()->json($validationResult, 422);
            }

            $query->where('institution_id', $request->query('institution_id'))
                ->where('district_id', $request->query('district_id'));
        }
        $institutionId = Auth::user()->institution_id;
        $teachers = Teacher::with(['branch' => static function ($query) {
            $query->select('id', 'name');
        }])
//            ->where('institution_id', $institutionId)
            ->get();

        return response()->json($teachers);
    }


    public function getTable(Request $request): JsonResponse
    {
        $query = Teacher::with('institution:id,district_id,name', 'branch:id,name');
        $user = Auth::user();

        // TODO refaktör gerekebilir
        // Kullanıcı 2i seviye(leve2) ise yani ilçe Mem kullanıcısı ise sadece kendi ilçesini listeleyebilsin
        // Yetkiye en üst seviyeden başlayarak bakabiliriz böylece üst else if yapısı amacına uygun çalışmış olur
        if ($user && $user->can('teacher.list.level3')) {
            $this->checkDistrict($request, $query);
            $this->checkInstitution($request, $query);
            $this->checkBranch($request, $query);
        } else if ($user && $user->can('teacher.list.level2')) {
            $query->whereHas('institution', static function (Builder $q) use ($user) {
                $q->where('district_id', $user->institution()->district_id);
            });
            $this->checkInstitution($request, $query);
            $this->checkBranch($request, $query);
        } else if ($user && $user->can('teacher.list.level1')) {
            $query->whereHas('institution', static function (Builder $q) use ($user) {
                $q->where('district_id', $user->institution()->district_id);
            });
            $query->where('institution_id', '=', $user->institution()->id);
            $this->checkBranch($request, $query);
        } else {
            return response()->json($this->unauthorized());
        }

        return Datatables::eloquent($query)
            ->toJson();
    }

    /**
     * @param Request $request
     * @param Builder $query
     */
    private function checkBranch(Request $request, Builder $query): void
    {
        if ($request->has('branch_id') && !is_null($request->input('branch_id'))) {
            $query->where('branch_id', '=', $request->input('branch_id'));
        }
    }

    /**
     * @param Request $request
     * @param Builder $query
     */
    private function checkInstitution(Request $request, Builder $query): void
    {
        if ($request->has('institution_id') && !is_null($request->input('institution_id'))) {
            $query->where('institution_id', '=', $request->input('institution_id'));
        }
    }

    /**
     * @param Request $request
     * @param Builder $query
     */
    private function checkDistrict(Request $request, Builder $query): void
    {
        if ($request->has('district_id') && !is_null($request->input('district_id'))) {
            $query->whereHas('institution', static function (Builder $q) use ($request) {
                $q->where('district_id', $request->input('district_id'));
            });
        }
    }

}