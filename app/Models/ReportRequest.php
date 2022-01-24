<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportRequest extends Model
{
    protected $table='ogs_report_requests';

    protected $fillable = [
        'plan_id', 'institution_id',
        'description', 'creator_id', 'code',
        'report', 'file', 'file_name', 'state'
    ];

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(DevPlan::class, 'plan_id');
    }

}

class State {
    public const OPEN = 1;
    public const LOADED = 2;
    public const CLOSED = 3;
}