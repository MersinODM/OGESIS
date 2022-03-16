<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Activity extends Model
{
    protected $table = "ogs_activities";

    protected $fillable = [
        'institution_id',"plan_id", "type_id", "theme_id",
        'team_id', "title", "description", "status", "creator_id",
        "start_date", "end_date",
        'planned_start_date', 'planned_end_date'
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(DevPlan::class, "plan_id");
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, "institution_id");
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ActivityType::class, "type_id");
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(ActivityTheme::class, "theme_id");
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'ogs_activity_members', "activity_id", "teacher_id");
    }

    public function partners(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'ogs_activity_partners', "activity_id", "partner_id");
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}