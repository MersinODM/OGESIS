<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'ogs_branches';

    protected $fillable = [
        'code',
        'name',
        'levels'
    ];
}