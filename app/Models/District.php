<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    protected $table = "ogs_districts";

    protected $fillable = [
      "code", "name"
    ];

    public function institutions(): HasMany
    {
        return $this->hasMany(Institution::class, 'district_id');
    }
}