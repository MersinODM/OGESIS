<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Partner extends Model
{
    protected $table='ogs_partners';

    protected $fillable = [
        'name', 'code'
    ];

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'ogs_activity_partners', "partner_id", "activity_id");
    }
}