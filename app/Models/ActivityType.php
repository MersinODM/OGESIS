<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
    protected $table = "ogs_activity_types";

    protected $fillable = [
        "name", "code"
    ];
}