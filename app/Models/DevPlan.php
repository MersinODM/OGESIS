<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevPlan extends Model
{
    use HasFactory;

    protected $table="ogs_dev_plans";

    protected $fillable = [
        "institution_id", "start_date", "end_date",
        "description", "report_name", "report_file"
    ];

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, "institution_id");
    }
}
