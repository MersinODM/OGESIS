<?php /** @noinspection NullPointerExceptionInspection */

namespace App\Http\Controllers\Api;

use App\Helpers\Permissions;
use App\Http\Controllers\ApiController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Utils\{ResponseCodes, ResponseKeys};
use App\Models\{Teacher, Team};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB};
use Yajra\DataTables\Facades\DataTables;

class TeamController extends ApiController
{
    /*
     *
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        $validationResult = $this->apiValidator($request, [
            'institution_id' => Rule::requiredIf($user->can([Permissions::LEVEL_3, Permissions::LEVEL_2])),
            'name' => 'required',
            'teachers' => 'required|array|min:2'
        ]);


        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $team = new Team([
                'name' => $request->input('name'),
                'institution_id' => $request->has('institution_id') ? $request->input('institution_id') : $user->institution_id,
            ]);
            $team->save();
            // Oluşturduğumuz takıma öğretmenleri atıyoruz
            $team->teachers()->attach($request->get('teachers'));
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
        $validationResult = $this->apiValidator($request, [
            'institution_id' => Rule::requiredIf($user->can([Permissions::LEVEL_3, Permissions::LEVEL_2])),
            'name' => 'required',
            'teachers' => 'required|array|min:2'
        ]);

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

    /*
     * Tüm öğretmenleri getiren api endpoint
     */
    public function get($district_id, $institution_id): JsonResponse
    {
        $user = Auth::user();
        if ($user && $user->cannot('team.list.*')) {
            return $this->unauthorized();
        }
        $query = Team::with(['teachers' => static function ($query) {
            $query->join('ogs_branches as b', 'b.id', '=', 'branch_id')
                ->select('ogs_teachers.id', 'branch_id', DB::raw('CONCAT(first_name, " ", last_name) as full_name'), 'b.name as branch');
        }])
            ->select('id', 'institution_id', 'name');
        if ($user->can(Permissions::LEVEL_3)) {
            $query->where('institution_id', $institution_id)
                ->whereHas('institution', static function (Builder $q) use ($district_id) {
                    $q->where('district_id', $district_id);
                });
            return response()->json($query->get());
        }
        if ($user->can(Permissions::LEVEL_2)) {
            $query->where('institution_id', $institution_id)
                ->whereHas('institution', static function (Builder $q) use ($user) {
                    $q->where('district_id', $user->institution()->district_id);
                });
            return response()->json($query->get());
        }
        if ($user->can(Permissions::LEVEL_1)) {
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
        $query = Team::with('institution:id,district_id,name', 'institution.district:id,name')
            ->select('id', 'name', 'institution_id');
        $user = Auth::user();

        // Yetki 3. seviye ise gönderilen veri içinde district id yok ise tümü ilçelerdeki kurumlar listelenir
        if ($user->can(Permissions::LEVEL_3)) {
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
            $query->whereRelation('institution', 'district_id', '=', $user->institution()->district_id);
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