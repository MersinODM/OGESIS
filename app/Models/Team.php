<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    protected $table = "ogs_teams";

    protected $fillable = [
        "name",
        "institution_id"
    ];

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'ogs_team_teachers', "team_id", "teacher_id");
    }

//    public function teachersWithBranches(): BelongsToMany {
//        return $this->belongsToMany(Teacher::class, 'ogs_team_teachers', "team_id", "teacher_id")
//            ->with(["branches:id,name"]);
//    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}