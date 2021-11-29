<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    protected $table = "ogs_teachers";

    protected $fillable = [
        "institution_id", "first_name", "last_name",
        "phone", "email", "branch_id"
    ];

    public function teams(): BelongsToMany {
        return $this->belongsToMany(Team::class, 'ogs_team_teachers', "teacher_id", "team_id");
    }

    public function activities(): BelongsToMany {
        return $this->belongsToMany(Activity::class, 'ogs_activity_members', "teacher_id", "activity_id");
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, "institution_id");
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, "branch_id");
    }
}