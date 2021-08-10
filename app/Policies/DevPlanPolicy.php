<?php

namespace App\Policies;

use App\Models\DevPlan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DevPlanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param DevPlan $devPlan
     * @return Response|bool
     */
    public function view(User $user, DevPlan $devPlan)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param DevPlan $devPlan
     * @return Response|bool
     */
    public function update(User $user, DevPlan $devPlan)
    {
        $ll = $user->inst_id;
        $po = $devPlan->institution_id;
        $res =  $user->hasRole('admin') ||
            ($user->hasRole('inst-comanager') &&
                $user->inst_id === $devPlan->institution_id);
        return $res;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param DevPlan $devPlan
     * @return Response|bool
     */
    public function delete(User $user, DevPlan $devPlan)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param DevPlan $devPlan
     * @return Response|bool
     */
    public function restore(User $user, DevPlan $devPlan)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param DevPlan $devPlan
     * @return Response|bool
     */
    public function forceDelete(User $user, DevPlan $devPlan)
    {
        //
    }
}
