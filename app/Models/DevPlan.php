<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DevPlan extends Model
{
    use HasFactory;

    protected $table="ogs_dev_plans";

    protected $fillable = [
        'name',
        "start_date", "end_date",
        "description",
        "is_open"
    ];

    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(Institution::class, 'ogs_institution_plans', 'plan_id', 'institution_id');
    }
}
