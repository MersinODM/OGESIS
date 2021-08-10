<?php

namespace App\Models;

use App\Traits\SelfReferencing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivityTheme extends Model
{
    use SelfReferencing;

    protected $table = "ogs_activity_themes";

    protected $fillable = [
        "parent_id", "code", "name"
    ];

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, "theme_id");
    }
}