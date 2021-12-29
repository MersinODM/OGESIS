<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Permissions;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
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
    /*
     * İl ve ilçe seviyelerinde kurum id gelmek zorunda
     * Okul seviyesinde gerekli değil okul yetkilisinin kendi kurum id sini vererek
     * öğretmen kaydını yapıyoruz
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $teacher = new Teacher();
        if ($user && ($user->can(Permissions::TEACHER_CREATE_LEVEL_3)
                || $user->can(Permissions::TEACHER_CREATE_LEVEL_2))) {
            $validationResult = $this->apiValidator($request, [
                'branch_id' => 'required',
                'institution_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
            ]);
            if ($validationResult) {
                return response()->json($validationResult, 422);
            }
            $teacher->fill($request->all());
        } else if ($user && $user->can(Permissions::TEACHER_CREATE_LEVEL_1)) {
            $validationResult = $this->apiValidator($request, [
                'branch_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
            ]);
            if ($validationResult) {
                return response()->json($validationResult, 422);
            }
            $teacher->fill($request->all());
            $teacher->institution_id = $user->institution_id;
        } else {
           return $this->unauthorized();
        }

        try {
            DB::beginTransaction();
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
        $query = Teacher::with(['branch:id,name', 'institution:id,district_id,name'])
            ->select('id', 'branch_id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'));

        if ($user && $user->can(Permissions::TEACHER_LIST_LEVEL_3)) {
            $validationResult = $this->apiValidator($request, [
                'district_id' => 'required',
                'institution_id' => 'required',
            ]);
            if ($validationResult) {
                return response()->json($validationResult, 422);
            }
            // kurumun bağlı olduğu ilçeyi de kontrol edelim
            $query->where('institution_id', $request->query('institution_id'))
                ->whereHas('institution', static function (Builder $q) use ($request) {
                    $q->where('district_id', $request->query('district_id'));
                });
            return response()->json($query->get());
        }

        if ($user && $user->can(Permissions::TEACHER_LIST_LEVEL_2)) {
            $validationResult = $this->apiValidator($request, [
                'institution_id' => 'required',
            ]);
            if ($validationResult) {
                return response()->json($validationResult, 422);
            }

            $query->where('institution_id', $request->query('institution_id'))
                ->where('district_id', $request->query('district_id'));
            return response()->json($query->get());
        }
        $institutionId = Auth::user()->institution_id;
        $teachers = Teacher::with(['branch' => static function ($query) {
            $query->select('id', 'name');
        }])
//            ->where('institution_id', $institutionId)
            ->get();

        return response()->json($teachers);
    }

    /*
     * Tüm öğretmenleri getiren api endpoint
     */
    public function get($district_id, $institution_id): JsonResponse
    {
        $user = Auth::user();
        if ($user && $user->cannot([Permissions::TEACHER_LIST_LEVEL_2, Permissions::TEACHER_LIST_LEVEL_3])) {
            return $this->unauthorized();
        }
        $query = Teacher::with(['branch:id,name'])
            ->select('id', 'branch_id', 'institution_id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'));
        if ($user->can(Permissions::TEAM_ADD_MEMBER_LEVEL_3)) {
            $query->where('institution_id', $institution_id)
                ->whereHas('institution', static function (Builder $q) use ($district_id) {
                    $q->where('district_id', $district_id);
                });
            return response()->json($query->get());
        }
        if ($user->can(Permissions::TEACHER_CREATE_LEVEL_2)) {
            $query->where('institution_id', $institution_id)
                ->whereHas('institution', static function (Builder $q) use ($user) {
                    $q->where('district_id', $user->institution()->district_id);
                });
            return response()->json($query->get());
        }
        if ($user->can(Permissions::TEACHER_CREATE_LEVEL_1)) {
            $query->where('institution_id', $user->institution_id)
                ->whereHas('institution', static function (Builder $q) use ($user) {
                    $q->where('district_id', $user->institution()->district_id);
                });
            return response()->json($query->get());
        }
        return $this->unauthorized();
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
            return $this->unauthorized();
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