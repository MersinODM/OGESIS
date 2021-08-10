<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    protected $table = "ogs_teams";

    protected $fillable = [
        "team_name",
        "plan_id"
    ];

    public function plan():BelongsTo {
        return $this->belongsTo(DevPlan::class, "plan_id");
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'ogs_team_teachers', "team_id", "teacher_id");
    }
}