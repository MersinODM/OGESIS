<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    protected $table = "ogs_activities";

    protected $fillable = [
        "plan_id", "type_id", "theme_id",
        "title", "description", "status", "creator_id",
        "start_date", "end_date"
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(DevPlan::class, "plan_id");
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ActivityType::class, "type_id");
    }

    public function activityTheme(): BelongsTo
    {
        return $this->belongsTo(ActivityTheme::class, "theme_id");
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'ogs_activity_members', "activity_id", "teacher_id");
    }
}