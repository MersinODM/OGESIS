<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportRequest extends Model
{
    protected $table='ogs_report_requests';

    protected $fillable = [
        'plan_id', 'institution_id',
        'description', 'creator_id', 'code',
        'report', 'file', 'file_name'
    ];


}