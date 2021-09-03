<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = "ogs_districts";

    protected $fillable = [
      "code", "name"
    ];
}